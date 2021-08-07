<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
class ApiController extends CController
{
    private $r = array('success'=>false, 'errors'=>array(), 'data'=>array());
    static $methodField = '_MulticraftAPIMethod';
    static $userField = '_MulticraftAPIUser';
    static $keyField = '_MulticraftAPIKey';
    private $enabled = true;
    private $clientUser = false;
    private $clientKey = false;

    public function init()
    {
        parent::init();
        $this->enabled = (Yii::app()->params['api_enabled'] === true);
    }
    
    private function validateKey($action)
    {
        if (!$this->enabled)
            $this->end('API not enabled.');

        $params = $this->getActionParams();
        $this->clientUser = CHtml::decode(''.@$params[ApiController::$userField]);
        $this->clientKey = CHtml::decode(''.@$params[ApiController::$keyField]);
        unset($params[ApiController::$keyField]);

        if (!$this->clientUser)
            $this->end('No API user supplied.');

        if (IpCounter::blocked())
            $this->end('API login temporarily blocked.');

        $user = User::model()->findByAttributes(array('name'=>$this->clientUser));
        if (!$user)
            $this->validateFailed('Invalid API user: '.$this->clientUser);
        $str = '';
        $expect = false;
        if (strlen($this->clientKey) == 32)
        {
            if (!$user->api_key)
                $this->validateFailed('No API key for user: '.$user->name);
            if (@Yii::app()->params['support_legacy_api'])
            {
                foreach ($params as $param)
                    $str .= $param;
                $expect = md5($user->api_key.$str);
            }
            else
            {
                Yii::log('API: Legacy API request from user: '.$user->name);
                $this->end('Legacy API support disabled.');
            }
        }
        else
        {
            foreach ($params as $key=>$value)
                $str .= $key.$value;
            $verifyKey = $user->api_key;
            if ($action->id == 'getOwnApiKey' && isset($params['password']))
            {
                if ($user->name == Yii::app()->user->superuser || !in_array($user->global_role, array('', 'none')))
                    $this->end('function not available for privileged users');
                $tempIdent = new UserIdentity($user->name, $params['password']);
                $tempIdent->authenticate(true, @$params['gauth_code']);
                if ($tempIdent->errorCode === UserIdentity::ERROR_GAUTH_CODE_INVALID)
                {
                    if (!isset($params['gauth_code']))
                        $this->end('gauth_code required');
                    else
                        $this->validateFailed('Invalid gauth_code for: '.$user->name);
                }
                else if ($tempIdent->errorCode !== UserIdentity::ERROR_NONE)
                    $this->validateFailed('Wrong password for: '.$user->name);
                $verifyKey = 'password';
            }
            else if (!$user->api_key)
                $this->validateFailed('No API key for user: '.$user->name);
            $expect = hash_hmac('sha256', $str, $verifyKey);
        }
        if (!$expect || (sha1($this->clientKey) != sha1($expect)))
            $this->validateFailed('Incorrect API key from user: '.$user->name);
        if (!Yii::app()->user->apiLogin($user))
            $this->validateFailed('API or superuser IP access denied for: '.$user->name);
    }

    private function validateFailed($log)
    {
        Yii::log('API: '.$log);
        IpCounter::recordFail();
        $this->end($log);
    }

    private function check($serverId = 0, $model = '')
    {
        $serverId = (int)$serverId;
        if (Yii::app()->user->isSuperuser())
            return true;
        if ($serverId && Yii::app()->user->serverRole($serverId) == 'owner')
            return true;
        if (!$serverId && !$model)
            $this->end('Access denied.');
        else
            $this->end(($model ? $model : 'Server').' not found');
    }

    private function checkModel($model, $id, $svField = 'server_id')
    {
        $m = $this->model($model, $id);
        return $this->check($m ? $m->{$svField} : 0, $model);
    }

    private function addData($name, $value)
    {
        $this->r['data'][CHtml::encode($name)] = is_array($value) ? CHtml::encodeArray($value) : CHtml::encode($value);
    }

    private function addError($error)
    {
        $this->r['errors'][] = is_array($error) ? CHtml::encodeArray($error) : CHtml::encode($error);
        return false;
    }

    private function success()
    {
        $this->r['success'] = true;
    }
    
    private function end($error = false)
    {
        if ($error)
            $this->addError($error);
        echo CJSON::encode($this->r);
        Yii::app()->end(); die();
    }

    public function endRequest($event)
    {
        //Yii::getLogger()->flush(true);
        Yii::app()->user->logout();
    }

    public function decodeArray($data, $r = 0)
    {
        $d = array();
        foreach($data as $key=>$value)
        {
            if(!is_scalar($key))
                continue;
            if(is_scalar($value))
                $value = CHtml::decode(''.$value);
            else if(is_array($value) && $r < 4)
                $value = $this->decodeArray($value, $r + 1);
            else
                $this->end('Error decoding parameters');
            $d[CHtml::decode(''.$key)] = $value;
        }
        return $d;
    }

    public function getActionParams()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $arr = $_POST;
            $_POST = $this->decodeArray($_POST);
            return $arr;
        }
        else if (Yii::app()->params['api_allow_get'] === true)
        {
            $arr = $_GET;
            $_GET = $this->decodeArray($_GET);
            return $arr;
        }
        $this->end('Invalid API request');
    }

    public function runAction($action)
    {
        Yii::app()->onEndRequest = array($this, 'endRequest');
        if (@strlen(Yii::app()->params['api_ips']) && !Yii::app()->user->checkIp(Yii::app()->params['api_ips']))
        {
            Yii::log('API access denied (IP '.Yii::app()->user->ip.')');
            $this->end('API access denied');
        }
        $this->validateKey($action);
        try
        {
            parent::runAction($action);
        }
        catch (ReflectionException $e)
        {
            $this->end('Invalid API call.');
        }
        catch (Exception $e)
        {
            $this->end($e->getMessage());
        }
        $this->end();
    }

    public function missingAction($actionID)
    {
        if (!$actionID)
            $this->end('No API function specified.');
        $this->end('No such API function: "'.$actionID.'"');
    }

    public function actionError()
    {
        $msg = '.';
        if (Yii::app()->errorHandler->error)
        {
            $e = Yii::app()->errorHandler->error;
            $msg = ': '.$e['code'].' - '.$e['message'];
        }
        Yii::log('API: Error handling API call'.$msg);
        $this->end('Error handling API call'.$msg);
    }

    private function model($model, $id)
    {
        $m = call_user_func(array($model, 'model'))->findByPk($id);
        if (!$m)
            $this->end($model.' not found');
        return $m;       
    }

    private function ls($model, $ms = false, $pk = 'id', $name = 'name', $details = false, $remove = array())
    {
        if (!is_array($ms))
            $ms = call_user_func(array($model, 'model'))->findAll(array('order'=>'id asc'));
        $ret = array();
        foreach ($ms as $m)
        {
            if ($details)
            {
                $data = $m->attributes;
                foreach ($remove as $rm)
                    unset($data[$rm]);
                $ret[$m->{$pk}] = $data;
            }
            else
                $ret[$m->{$pk}] = $m->{$name};
        }
        $this->addData($model.'s', $ret);
        $this->success();
    }

    private function get($model, $id, $remove = array())
    {
        $m = $this->model($model, $id);
        $data = $m->attributes;
        foreach ($remove as $rm)
            unset($data[$rm]);
        $this->addData($model, $data);
        $this->success();
    }

    private function toAttributeArray($field, $value)
    {
        $field = CJSON::decode($field);
        $value = CJSON::decode($value);
        if (!is_array($field))
            $field = array($field);
        if (!is_array($value))
            $value = array($value);
        $cmin = min(count($field), count($value));
        return array_combine(array_slice($field, 0, $cmin), array_slice($value, 0, $cmin));
    }
    
    private function upd($model, $id, $field, $value, $remove = array('id'), $sendData = false)
    {
        $m = $this->model($model, $id);
        if ($model == 'User' && ($m->name == Yii::app()->user->superuser || $m->global_role == 'superuser'))
            $this->end('Access denied');

        Yii::log('API: Updating model '.$model.', '.$id);

        $all = $this->toAttributeArray($field, $value);

        foreach ($all as $k=>$v)
        {
            if (in_array($k, $remove) || !$m->hasAttribute($k))
                $this->end($model.' does not have an attribute "'.$k.'"');
            $m->{$k} = $v;
        }
        if ($model == 'User' && Yii::app()->user->isSuperuser() && in_array(substr($m->password, 0, 4), array('$2y$', '$5$r', '$6$r')) && strlen($m->password) >= 60)
            $m->prevPassword = $m->password; // make sure the hash gets saved

        if ($sendData)
            $m->sendData = true;
        if (!$m->save())
            $this->end($m->errors);
        else
            $this->success();
    }

    private function create($model, $attribs, $scenario='create', $remove = array('id'))
    {
        $m = new $model($scenario);
        foreach ($attribs as $a=>$v)
        {
            if (in_array($a, $remove) || (!$m->hasAttribute($a) && !property_exists($m, $a)))
                $this->end($model.' does not have an attribute "'.$a.'"');
            $m->{$a} = $v;
        }
        if (!$m->save())
            $this->end($m->errors);
        else
        {
            Yii::log('API: Created model '.$model.', '.$m->id);
            $this->addData('id', $m->id);
            $this->success();
            return $m;
        }
    }

    private function del($model, $id)
    {
        $m = $this->model($model, $id);
        if ($model == 'User' && ($m->name == Yii::app()->user->superuser || $m->global_role == 'superuser'))
            $this->end('Access denied');
        Yii::log('API: Deleting model '.$model.', '.$id);
        if (!$m->delete())
            $this->end($m->errors);
        else
            $this->success();
    }

    private function svCmd($id, $cmd)
    {
        Yii::log('API: Sending command to server '.$id.': "'.$cmd.'"');
        if (!McBridge::get()->serverCmd($id, $cmd, $data))
            $this->end(McBridge::get()->lastError());
        else
        {
            foreach ($data as $k => $v)
                $this->addData($k, $v);
            $this->success();
        }
    }

    private function allCmd($cmd)
    {
        Yii::log('API: Sending command to all servers: "'.$cmd.'"');
        $ret = McBridge::get()->globalCmd('server all:'.$cmd);
        foreach ($ret as $id => $data)
        {
            foreach ($data as $k => $v)
                $this->addData('['.$id.']'.$k, $v);
        }
        $this->success();
    }

    private function find($modelName, $field, $value, $addCrit = array(), $scenario = 'search', $remove = array(), $details = false)
    {
        $model = new $modelName($scenario);
        $model->unsetAttributes();

        $crit = $this->toAttributeArray($field, $value);

        foreach ($crit as $k=>$v)
        {
            if (in_array($k, $remove) || !$model->hasAttribute($k))
                $this->end($modelName.' does not have an attribute "'.$k.'"');
        }

        $model->attributes = array_merge($crit, $addCrit);
        $provider = $model->search();
        $provider->pagination = false;
        $this->ls($modelName, $provider->data, 'id', 'name', $details, $remove);
    }

/**
 ** User Functions
 **/
    public function actionListUsers() { $this->check(); $this->ls('User'); }

    public function actionFindUsers($field, $value) { $this->check(); $this->find('User', $field, $value); }

    public function actionGetUser($id) { $this->check(); $this->get('User', (int)$id, array('password', 'api_key', 'reset_hash')); }

    public function actionGetCurrentUser()
    {
        /* accessible by everyone with an API key */
        $this->get('User', (int)Yii::app()->user->id, array('password', 'api_key', 'reset_hash'));
    }

    public function actionUpdateUser($id, $field, $value, $send_mail = 0) {
        $this->check(); $this->upd('User', (int)$id, $field, $value, array('id'), $send_mail); }

    public function actionCreateUser($name, $email, $password, $lang = '', $send_mail = 0) {
        $this->check(); $this->create('User', array('name'=>$name, 'email'=>$email, 'password'=>$password, 'lang'=>$lang, 'sendData'=>$send_mail)); }

    public function actionDeleteUser($id) { $this->check(); $this->del('User', (int)$id); }

    public function actionGetUserFtpAccess($user_id, $server_id)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $usr = $this->model('User', (int)$user_id);

        $this->addData('mode', $usr->getServerFtpAccess($sv->id));
        $this->success();
    }

    public function actionSetUserFtpAccess($user_id, $server_id, $mode)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $usr = $this->model('User', (int)$user_id);

        if (!$sv->id)
            $this->end('Invalid server');

        Yii::log('API: Setting FTP access for server '.$sv->id.' of user '.$usr->id.' to '.$mode);
        if ($usr->setServerFtpAccess($sv->id, $mode))
            $this->success();
    }

    public function actionGetUserRole($user_id, $server_id)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $usr = $this->model('User', (int)$user_id);

        $this->addData('role', $usr->getServerRole($sv->id));
        $this->success();
    }

    public function actionSetUserRole($user_id, $server_id, $role)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $usr = $this->model('User', (int)$user_id);

        if ($role && ($role == 'owner' || !in_array($role, User::$roles)))
            $this->end('Invalid role.');
        Yii::log('API: Setting server role for server '.$sv->id.' of user '.$usr->id.' to '.$role);
        if ($usr->setServerRole($sv->id, $role))
            $this->success();
    }

    public function actionGetUserId($name)
    {
        //accessible by everyone with an API key
        $usr = User::model()->findAllByAttributes(array('name'=>$name));

        if (!$usr || !count($usr) || (count($usr) != 1))
            $this->end('User not found.');
        $this->addData('id', $usr[0]->id);
        $this->success();
    }

    public function actionValidateUser($name, $password)
    {
        $this->check();
        $usr = User::model()->findAllByAttributes(array('name'=>$name));

        if (!$usr || !count($usr) || (count($usr) != 1))
            $this->end('User not found.');
        if ($usr[0]->password != crypt($password, $usr[0]->password))
            $this->end('Password incorrect.');
        $this->success();
    }

    public function actionGenerateUserApiKey($user_id)
    {
        $this->check();
        $usr = $this->model('User', (int)$user_id);
        if (!strlen($usr->api_key))
        {
            $usr->generateApiKey();
            $usr->save(false);
        }
        $this->addData('api_key', $usr->api_key);
        $this->success();
    }

    public function actionGetUserApiKey($user_id)
    {
        $this->check();
        $usr = $this->model('User', (int)$user_id);
        if (!strlen($usr->api_key))
            $this->end('This user doesn\'t have an API key');
        $this->addData('api_key', $usr->api_key);
        $this->success();
    }


    public function actionRemoveUserApiKey($user_id)
    {
        $this->check();
        $usr = $this->model('User', (int)$user_id);
        if (strlen($usr->api_key))
        {
            $usr->api_key = '';
            $usr->save(false);
        }
        $this->success();
    }

    public function actionGetOwnApiKey($password, $generate = 0)
    {
        // Allow any user
        $user = Yii::app()->user->model;
        if (!strlen($user->api_key))
        {
            if (!$generate || Yii::app()->params['user_api_keys'] !== true)
                $this->end('This user doesn\'t have an API key');
            $user->generateApiKey();
            $user->save(false);
        }
        $this->addData('api_key', $user->api_key);
        $this->success();
    }

/**
 ** Player Functions
 **/
    public function actionListPlayers($server_id)
    {
        $this->check($server_id); //allow owner
        $plrs = Player::model()->findAllByAttributes(array('server_id'=>(int)$server_id));
        $this->ls('Player', $plrs);
    }

    public function actionFindPlayers($server_id, $field, $value)
    {
        $this->check($server_id); //allow owner
        $this->find('Player', $field, $value, array('server_id'=>(int)$server_id));
    }

    public function actionGetPlayer($id) { $this->checkModel('Player', (int)$id); $this->get('Player', (int)$id); }

    public function actionUpdatePlayer($id, $field, $value) {
        $this->checkModel('Player', (int)$id); $this->upd('Player', (int)$id, $field, $value, array('id', 'server_id')); }

    public function actionCreatePlayer($server_id, $name, $op_command = 0)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $this->create('Player', array('server_id'=>$sv->id, 'name'=>$name));

        if ($op_command && preg_match('/[-\w\.\s_]+/', $name))
        {
            Yii::log('API: Adding Op command');
            $cmd = new Command;
            $cmd->server_id = $sv->id;
            $cmd->name = Yii::t('mc', 'Op Server Owner');
            $cmd->level = 50;
            $cmd->run = 'op '.$name;
            $cmd->save();
            Yii::log('API: Scheduling Op command');
            $sched = new Schedule;
            $sched->server_id = $sv->id;
            $sched->scheduled_ts = time() + 60;
            $sched->name = Yii::t('mc', 'Op Server Owner');
            $sched->command = $cmd->id;
            $sched->save();
        }
    }

    public function actionDeletePlayer($id) { $this->checkModel('Player', (int)$id); $this->del('Player', (int)$id); }

    public function actionAssignPlayerToUser($player_id, $user_id)
    {
        $this->checkModel('Player', (int)$player_id);
        $pl = $this->model('Player', (int)$player_id);
        if ($user_id)
            $usr = $this->model('User', (int)$user_id);
        Yii::log('API: Assigning player '.$player_id.' to user '.$user_id);

        if ($pl->user = (int)$user_id)
            $this->success();
    }

/**
 ** Command Functions
 **/
    public function actionListCommands($server_id)
    {
        $this->check($server_id); //allow owner
        $cmds = Command::model()->findAllByAttributes(array('server_id'=>(int)$server_id));
        $this->ls('Command', $cmds);
    }

    public function actionFindCommands($server_id, $field, $value)
    {
        $this->check($server_id); //allow owner
        $this->find('Command', $field, $value, array('server_id'=>(int)$server_id));
    }

    public function actionGetCommand($id) { $this->checkModel('Command', (int)$id); $this->get('Command', (int)$id); }

    public function actionUpdateCommand($id, $field, $value) {
        $this->checkModel('Command', (int)$id); $this->upd('Command', (int)$id, $field, $value, array('id', 'server_id')); }

    public function actionCreateCommand($server_id, $name, $role, $chat, $response, $run)
    {
        $this->check($server_id); //allow owner
        $sv = $this->model('Server', (int)$server_id);
        $this->create('Command', array('server_id'=>$sv->id, 'name'=>$name, 'level'=>User::getRoleLevel($role),
                'chat'=>$chat, 'response'=>$response, 'run'=>$run));
    }

    public function actionDeleteCommand($id) { $this->checkModel('Command', (int)$id); $this->del('Command', (int)$id); }

/**
 ** Server Functions
 **/
    public function actionListServers() { $this->check(); $this->ls('Server'); }

    public function actionFindServers($field, $value, $details) { $this->check(); $this->find('Server', $field, $value, array(), 'search', array(), $details); }

    public function actionListServersByConnection($connection_id)
    {
        $this->check();
        $svs = Server::model()->findAllByAttributes(array('daemon_id'=>(int)$connection_id));
        $this->ls('Server', $svs);
    }

    public function actionListServersByOwner($user_id)
    {
        $user_id = (int)$user_id;
        // Accessible by everyone with an API key
        // Servers can be queried for everyone as superuser or for own user only
        if (!Yii::app()->user->isSuperuser() && (((int)Yii::app()->user->id) !== $user_id))
            $this->end('Access denied.');
        $sql = 'select `server_id` from `user_server` where `user_id`=? and `role`=?';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(1, (int)$user_id);
        $cmd->bindValue(2, 'owner');
        $serverIds = $cmd->queryColumn();
        $svs = Server::model()->findAllByAttributes(array('id'=>$serverIds));
        $this->ls('Server', $svs);
    }

    public function actionGetServer($id)
    {
        $this->check($id); //allow owner with special handling
        if (!Yii::app()->user->isSuperuser())
        {
            $sv = $this->model('Server', (int)$id);
            $settings = $this->model('ServerConfig', $sv->id);
            $ip = trim(($settings && $settings->display_ip) ? $settings->display_ip : $sv->ip);
            if (!strlen($ip) || $ip == '0.0.0.0')
            {
                if ($dmn = Daemon::model()->findByPk($sv->daemon_id))
                    $ip = $dmn->ip;
            }
            $data = array(
                'name'=>$sv->name,
                'ip'=>$ip,
                'port'=>$sv->port,
                'players'=>$sv->players,
            );
            if (Yii::app()->params['show_memory'] || ($settings && $settings->user_memory))
                $data['memory'] = $sv->memory;
            $this->addData('Server', $data);
            $this->success();
        }
        else
            $this->get('Server', (int)$id);
    }

    public function actionUpdateServer($id, $field, $value) {
        $this->check(); $this->upd('Server', (int)$id, $field, $value); }

    private function initServer($model, $no_commands, $no_setup_script, $cfgAttribs = array())
    {
        $cfg = new ServerConfig();
        foreach ($cfgAttribs as $a=>$v)
        {
            if (in_array($a, array('server_id')) || !$cfg->hasAttribute($a))
                $this->end('ServerConfig does not have an attribute "'.$a.'"');
            $cfg->{$a} = $v;
        }
        $cfg->server_id = $model->id;
        $cfg->scenario = 'create';
        if (!$cfg->save())
            $this->addError($cfg->errors);
        if (!$no_commands)
            $model->createDefaultCommands();
        if (!$no_setup_script)
            McBridge::get()->serverCmd($model->id, 'run_s:builtin:script setup');
        return $cfg;
    }

    public function actionCreateServerOn($daemon_id = 0, $no_commands = 0, $no_setup_script = 0)
    {
        $this->check();
        if (!$daemon_id && McBridge::get()->connectionCount())
        {
            $ids = array_keys(McBridge::get()->conStrings());
            $daemon_id = $ids[0];
        }
        $model = $this->create('Server', array('daemon_id'=>(int)$daemon_id, 'dir'=>''), 'superuser');
        $this->initServer($model, $no_commands, $no_setup_script);
        $this->success();
    }

    public function actionCreateServer($name = '', $port = 0, $base = '', $players = 0, $no_commands = 0, $no_setup_script = 0)
    {
        $this->check();
        $attr = array(
            'name'=>$name,
            'dir'=>$base,
        );
        if ($port)
            $attr['port'] = $port;
        if ($players)
            $attr['players'] = $players;
        $model = $this->create('Server', $attr, 'superuser');
        $this->initServer($model, $no_commands, $no_setup_script);
        $this->success();
    }

    public function actionCreateAndConfigureServer($field, $value, $configField, $configValue, $no_commands = 0, $no_setup_script = 0)
    {
        $this->check();
        $model = $this->create('Server', $this->toAttributeArray($field, $value), 'superuser');
        $cfgAttribs = $this->toAttributeArray($configField, $configValue);
        $cfg = $this->initServer($model, $no_commands, $no_setup_script, $cfgAttribs);
        $this->success();
    }

    public function actionSuspendServer($id, $stop = 1)
    {
        $this->check();
        $m = $this->model('Server', (int)$id);
        Yii::log('API: Suspending server '.$id);
        if (!$m->suspend())
            $this->end($m->errors);
        $this->success();
        if ($stop)
            $this->actionStopServer($id);
    }

    public function actionResumeServer($id, $start = 1)
    {
        $this->check();
        $m = $this->model('Server', (int)$id);
        Yii::log('API: Resuming server '.$id);
        if (!$m->resume())
            $this->end($m->errors);
        $this->success();
        if ($start)
            $this->actionStartServer($id);
    }

    public function actionDeleteServer($id, $delete_dir = 'no', $delete_user = 'no')
    {
        $this->check();
        $m = $this->model('Server', (int)$id);
        if ($delete_dir === 'yes')
            $m->deleteDir = 'yes';
        Yii::log('API: Deleting server '.$id.', delete dir: '.$delete_dir.', delete_user: '.$delete_user);
        if ($delete_user === 'yes' && ($u = User::model()->findByPk($m->owner)))
        {
            $cmd = Yii::app()->db->createCommand('select count(*) from `user_server` where `role`=\'owner\' and `user_id`=?');
            $cmd->execute(array($u->id));
            if ($cmd->queryScalar() > 1)
                Yii::log('API: Not deleting user: Still owns other servers');
            else if(!$u->delete())
                $this->end($u->errors);
        }
        if (!$m->delete())
            $this->end($m->errors);
        else
            $this->success();
    }

    public function actionGetServerStatus($id, $player_list = 0)
    {
        $this->check($id); //allow owner
        $sv = $this->model('Server', (int)$id);
        $player_list = preg_match('/(1|true|TRUE|y|yes|YES)/', (string)$player_list);

        $pl = $sv->getOnlinePlayers();
        if ($pl >= 0)
        {
            $this->addData('status', 'online');
            $this->addData('onlinePlayers', $pl);
            if ($player_list)
            {
                if (!McBridge::get()->serverCmd($sv->id, 'get players', $players))
                    $this->addError(McBridge::get()->lastError());
                $this->addData('players', $players);
            }
        }
        else
        {
            $this->addData('status', 'offline');
            $this->addData('onlinePlayers', 0);
            if ($player_list)
                $this->addData('players', array());
        }
        $this->addData('maxPlayers', $sv->players);
        $this->success();
    }

    public function actionGetServerOwner($server_id)
    {
        $this->check();
        $sv = $this->model('Server', (int)$server_id);

        $owner = $sv->getOwner();
        $this->addData('user_id', $owner ? $owner : 0);
        $this->success();
    }

    public function actionSetServerOwner($server_id, $user_id, $send_mail = 0)
    {
        $this->check();
        $sv = $this->model('Server', (int)$server_id);
        if ($user_id) 
            $usr = $this->model('User', (int)$user_id);

        $sv->sendData = $send_mail;

        Yii::log('API: Setting owner of server '.$sv->id.' to '.$user_id);
        if ($sv->setOwner((int)$user_id))
            $this->success();
    }

    public function actionGetServerConfig($id) { $this->check(); $this->get('ServerConfig', (int)$id); }

    public function actionUpdateServerConfig($id, $field, $value) {
        $this->check(); $this->upd('ServerConfig', (int)$id, $field, $value, array('server_id')); }

    public function actionStartServerBackup($id) {
        $this->check($id); /*allow owner*/ $this->svCmd((int)$id, 'backup start'); }

    public function actionGetServerBackupStatus($id)
    {
        $this->check($id); //allow owner
        if (!McBridge::get()->serverCmd((int)$id, 'backup status', $status))
            $this->end(McBridge::get()->lastError());
        else
        {
            foreach ($status[0] as $k=>$v)
                $this->addData($k, $v);
            $this->success();
        }
    }

    public function actionStartServer($id) { $this->check($id); /*allow owner*/ $this->svCmd((int)$id, 'start'); }

    public function actionStopServer($id) { $this->check($id); /*allow owner*/ $this->svCmd((int)$id, 'stop'); }

    public function actionRestartServer($id) { $this->check($id); /*allow owner*/ $this->svCmd((int)$id, 'restart'); }

    public function actionKillServer($id) { $this->check($id); /*allow owner*/ $this->svCmd((int)$id, 'kill'); }

    public function actionStartAllServers() { $this->check(); $this->allCmd('start'); }

    public function actionStopAllServers() { $this->check(); $this->allCmd('stop'); }

    public function actionRestartAllServers() { $this->check(); $this->allCmd('restart'); }

    public function actionKillAllServers() { $this->check(); $this->allCmd('kill'); }

    public function actionSendConsoleCommand($server_id, $command, $as_superuser = false)
    {
        if ($as_superuser)
            $this->check();
        else
            $this->check($server_id);
        $this->svCmd((int)$server_id, ($as_superuser ?  'run_s:' : 'run:').$command);
    }

    public function actionSendAllConsoleCommand($command)
    {
        $this->check();
        $this->allCmd('run_s:'.$command);
    }

    public function actionRunCommand($server_id, $command_id, $run_for = 0)
    {
        $this->check($server_id); //allow owner
        $this->svCmd((int)$server_id, 'run command '.(int)$command_id.':'.(int)$run_for);
    }

    public function actionGetServerLog($id)
    {
        $this->check($id); //allow owner
        $this->svCmd((int)$id, 'get log');
    }

    public function actionClearServerLog($id)
    {
        $this->check($id); //allow owner
        $this->svCmd((int)$id, 'clear log');
    }

    public function actionGetServerChat($id)
    {
        $this->check($id); //allow owner
        $this->svCmd((int)$id, 'get chat');
    }

    public function actionClearServerChat($id)
    {
        $this->check($id); //allow owner
        $this->svCmd((int)$id, 'clear chat');
    }

    public function actionSendServerControl($id, $command)
    {
        $this->check();
        $this->svCmd((int)$id, $command);
    }

    public function actionGetServerResources($id)
    {
        $this->check($id); //allow owner
        $error = '';
        if (!McBridge::get()->serverCmd($id, 'get resources', $res))
            $error = McBridge::get()->lastError();
            
        if (strlen($error))
            return $this->end($error);

        $st = @$res[0];
        $this->addData('cpu', @$st['cpu']);
        $this->addData('memory', @$st['memory']);
        $this->addData('quota', @$st['quota']);
        $this->success();
    }

    public function actionMoveServer($server_id, $daemon_id)
    {
        $this->check();
        $server_id = (int)$server_id;
        $daemon_id = (int)$daemon_id;
        if (!$server_id)
            $this->end('Invalid server ID');
        if (!$daemon_id)
            $this->end('Invalid daemon ID');
        $this->svCmd($server_id, 'migrate '.$daemon_id);
    }

    public function actionGetMoveStatus($server_id)
    {
        $this->check();
        $server_id = (int)$server_id;
        if (!$server_id)
            $this->end('Invalid server ID');

        $sql = 'select `src_dmn`, `dst_dmn`, `status`, `message` from `move_status` where `server_id`=?';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $cmd->bindValue(1, $server_id);
        $row = $cmd->queryRow(false);
        if (!$row)
            return $this->end('No move in progress');

        $this->addData('src_daemon_id', $row[0]);
        $this->addData('dst_daemon_id', $row[1]);
        $this->addData('status', $row[2]);
        $this->addData('message', $row[3]);
        $this->success();
    }
       

/**
 ** Daemon functions
 **/
    public function actionListConnections() { $this->check(); $this->ls('Daemon'); }

    public function actionFindConnections($field, $value) { $this->check(); $this->find('Daemon', $field, $value); }

    public function actionGetConnection($id) { $this->check(); $this->get('Daemon', (int)$id); }

    public function actionRemoveConnection($id) { $this->check(); $this->del('Daemon', (int)$id); }

    public function actionGetConnectionStatus($id)
    {
        $this->check();
        $ret = McBridge::get()->cmd((int)$id, 'version');
        if (!$ret['success'])
            $this->end($ret['error']);

        foreach ($ret['data'][0] as $k=>$v)
            $this->addData($k, $v);
        $this->success();
    }

    public function actionGetConnectionMemory($id, $include_suspended = 0)
    {
        $this->check();
        if ($id)
        {
            $dmn = $this->model('Daemon', (int)$id);

            $this->addData('total', $dmn->memory);
            $this->addData('used', $dmn->getUsedMemory($include_suspended));
        }
        else
        {
            $sql = 'select `id`, `memory`, (select sum(`memory`) from `server` where `daemon_id`=`daemon`.`id`'
                .($include_suspended ? '' : ' and `suspended`=0').') as `used` from `daemon` group by `id` order by `id`';
            $cmd = Yii::app()->bridgeDb->createCommand($sql);
            $rows = $cmd->query();
            foreach ($rows as $row)
                $daemons[$row['id']] = ['total' => $row['memory'], 'used' => $row['used']];
            $this->addData('daemons', $daemons);
        }

        $this->success();
    }

    public function actionGetStatistics($id = 0, $daemon_id = 0, $include_suspended = 0)
    {
        $this->check();
        $dmn = false;
        $id = (int)$id;
        $daemon_id = (int)$daemon_id;
        if (!$id && $daemon_id)
            $id = $daemon_id;
        if ($id)
        {
            $dmn = $this->model('Daemon', (int)$id);
            if (!$dmn)
                $this->end('Daemon not found');
        }

        $cond = array();
        $sCond = '';
        $dCond = '';
        if ($dmn)
        {
            $dCond = ' where `id`=:did';
            $cond[] = '`daemon_id`=:did';
        }
        if (!$include_suspended)
            $cond[] = '`suspended`!=1';
        if (count($cond))
            $sCond = ' where '.implode(' and ', $cond);
        
        $sql = 'select '
            .'(select count(*) from `daemon`),'
            .'(select sum(`memory`) from `daemon`'.$dCond.'),'
            .'count(*),'
            .'sum(`players`),'
            .'sum(`memory`)'
            .' from `server`'.$sCond.'';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        if ($dmn)
            $cmd->bindValue(':did', $dmn->id);
        $row = $cmd->queryRow(false);

        if (!$row)
            $this->end('Error querying statistics');
        if ($dmn)
            $this->addData('daemon', $dmn->id);
        $this->addData('daemons', $row[0]);
        $this->addData('daemon_memory', $row[1]);
        $this->addData('servers', $row[2]);
        $this->addData('players', $row[3]);
        $this->addData('assigned_memory', $row[4]);

        $this->success();
    }

    public function actionRunScript($daemon_id, $script, $args = '')
    {
        $this->check();
        $ret = McBridge::get()->cmd((int)$daemon_id, 'runscript '.$script.($args ? ' '.$args : ''));
        if (!$ret['success'])
            $this->end($ret['error']);

        foreach ($ret['data'][0] as $k=>$v)
            $this->addData($k, $v);
        $this->success();
    }

    public function actionGetScript($daemon_id, $scriptId)
    {
        $this->check();
        $ret = McBridge::get()->cmd((int)$daemon_id, 'getscript '.$scriptId);
        if (!$ret['success'])
            $this->end($ret['error']);

        foreach ($ret['data'][0] as $k=>$v)
            $this->addData($k, $v);
        unset($ret['data'][0]);
        $output = '';
        foreach ($ret['data'] as $data)
            $output .= $data['line']."\n";
        $this->addData('output', $output);
        $this->success();
    }

/**
 ** Settings functions
 **/
    public function actionListSettings() { $this->check(); $this->ls('Setting', false, 'key', 'value'); }

    public function actionGetSetting($key) { $this->check(); $this->get('Setting', $key); }

    public function actionSetSetting($key, $value)
    {
        $this->check();
        $set = Setting::model()->findByPk($key);
        if (!$set)
        {
            $set = new Setting();
            $set->key = $key;
        }
        $set->value = $value;
        Yii::log('API: Set setting "'.$key.'" to "'.$value.'"');
        if (!$set->save())
            $this->end($set->errors);
        else
            $this->success();
    }

    public function actionDeleteSetting($key) { $this->check(); $this->del('Setting', $key); }

/**
 ** Schedule Functions
 **/
    private function checkSchedule($server_id)
    {
        $this->check($server_id); //allow owner
        
        if (Yii::app()->user->isSuperuser())
            return;

        $settings = $this->model('ServerConfig', (int)$server_id);
        if (!$settings || !$settings->user_schedule)
            $this->end('Schedule access denied.');
    }

    private function checkScheduleModel($id)
    {
        $m = $this->model('Schedule', $id);
        return $this->checkSchedule($m ? $m->server_id : 0);
    }

    public function actionListSchedules($server_id)
    {
        $this->checkSchedule($server_id);
        $cmds = Schedule::model()->findAllByAttributes(array('server_id'=>(int)$server_id));
        $this->ls('Schedule', $cmds);
    }

    public function actionFindSchedules($server_id, $field, $value)
    {
        $this->checkSchedule($server_id);
        $this->find('Schedule', $field, $value, array('server_id'=>(int)$server_id));
    }

    public function actionGetSchedule($id) { $this->checkScheduleModel((int)$id); $this->get('Schedule', (int)$id); }

    public function actionUpdateSchedule($id, $field, $value) {
        $this->checkScheduleModel((int)$id); $this->upd('Schedule', (int)$id, $field, $value, array('id', 'server_id')); }

    public function actionCreateSchedule($server_id, $name, $ts, $interval, $cmd, $status, $for)
    {
        $this->checkSchedule($server_id);
        $sv = $this->model('Server', (int)$server_id);
        $this->create('Schedule', array('server_id'=>$sv->id, 'name'=>$name, 'scheduled_ts'=>$ts,
                'interval'=>$interval, 'command'=>$cmd, 'status'=>$status, 'run_for'=>$for));
    }

    public function actionDeleteSchedule($id) { $this->checkScheduleModel((int)$id); $this->del('Schedule', (int)$id); }

/**
 ** Database Functions
 **/
    public function checkDb($server_id)
    {
        $this->check($server_id); //allow owner
        
        if (Yii::app()->user->isSuperuser())
            return;

        $settings = $this->model('ServerConfig', (int)$server_id);
        if (!Yii::app()->params['user_mysql'] || !$settings->user_mysql)
            $this->end('Database access denied.');
    }

    public function actionGetDatabaseInfo($server_id)
    {
        $this->checkDb($server_id);

        $sv = $this->model('Server', (int)$server_id);
        $dbInfo = $sv->dbInfo;

        if (!strlen(@$dbInfo[0]))
            $this->end('No database found for this server');

        $this->addData('host', $sv->mysqlHost);
        $this->addData('name', $dbInfo[0]);
        $this->addData('username', $dbInfo[0]);
        $this->addData('password', $dbInfo[1]);
        $this->addData('link', $sv->mysqlLink);
        $this->success();
    }

    public function actionCreateDatabase($server_id)
    {
        $this->checkDb($server_id);
        
        $sv = $this->model('Server', (int)$server_id);
        $dbInfo = $sv->dbInfo;

        if (strlen(@$dbInfo[0]))
            $this->end('Database already exists for this server');
        if (!$sv->createDatabase())
            $this->end('Failed to create database');
        $this->actionGetDatabaseInfo($server_id);
    }

    public function actionChangeDatabasePassword($server_id)
    {
        $this->checkDb($server_id);
        
        $sv = $this->model('Server', (int)$server_id);
        if (!$sv->changeDatabasePw())
            $this->end('Failed to change database password');
        $this->actionGetDatabaseInfo($server_id);
    }

    public function actionDeleteDatabase($server_id)
    {
        $this->checkDb($server_id);
        
        $sv = $this->model('Server', (int)$server_id);
        $dbInfo = $sv->dbInfo;

        if (!strlen(@$dbInfo[0]))
            $this->end('No database found for this server');
        if (!$sv->deleteDatabase())
            $this->end('Failed to delete database');
        $this->success();
    }

    public function actionListServerPorts($id)
    {
        $this->check();

        $model = $this->model('Server', (int)$id);
        $cmd = Yii::app()->bridgeDb->createCommand('select `port` as `id` from `server_port` where `server_id`=?');
        $ports = $cmd->bindValue(1, $model->id);
        $this->addData('ports', $cmd->queryColumn());
        $this->success();
    }

    public function actionAddServerPort($id, $port = 0)
    {
        $this->check();

        $model = $this->model('Server', (int)$id);
        $port = $model->addServerPort($port);
        if (!$port)
            $this->end($model->getError('port'));
        $this->addData('port', $port);
        $this->success();
    }

    public function actionRemoveServerPort($id, $port)
    {
        $this->check();

        $model = $this->model('Server', (int)$id);
        if (!$model->removeServerPort($port))
            $this->end($model->getError('port'));
        $this->success();
    }
}

