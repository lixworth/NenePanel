<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class ServerController extends Controller
{
    public $layout='//layouts/column2';
    public $mc = null;
    public $ip;

    public function init()
    {
        parent::init();
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->ip = preg_replace('/^[^\d]*/', '', $this->ip);
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'view', 'chat', 'public', 'log'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('update', 'users', 'backup', 'restore', 'restoreFull', 'configs', 'editConfig', 'editPermissionsConfig', 'ftp', 'localPlugins', 'mysqlDb', 'pluginList', 'plugin', 'setup', 'params', 'ports'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('admin', 'suspend', 'resume', 'dismiss'),
                'expression'=>'$user->isStaff()',
            ),
            array('allow',
                'actions'=>array('create', 'delete'),
                'expression'=>'$user->isSuperuser()',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    private $ownServerSql = 'select `us`.`server_id` from `user_server` as `us` join `server_config` as `sc` on `us`.`server_id`=`sc`.`server_id` where `user_id`=? and (`role` in (\'owner\', \'coowner\') or (`sc`.`visible`!=0 and `role`!=\'none\' and `role`!=\'\'))';

    private function listJars($id = 0)
    {
        $id = (int)$id;
        if ($id)
            $ret = array($id=>McBridge::get()->cmd(Server::getDaemon($id), 'updatejar list :'.$id));
        else
            $ret = array(); //McBridge::get()->globalCmd('updatejar list :'); // Uncomment this to query all daemons for available JARs

        $jars = false;
        foreach ($ret as $id=>$r)
        {
            if (!$r['success'])
                continue;
            if (!$jars)
                $jars = array(''=>array('jar'=>'', 'name'=>'Default', 'template'=>'', 'category'=>''));
            foreach ($r['data'] as $jar)
                $jars[@$jar['jar']] = array('jar'=>@$jar['jar'], 'name'=>@$jar['name'], 'template'=>@$jar['template'],
                    'category'=>@$jar['category'], 'icon'=>@$jar['icon']);
        }
        if ($jars)
        {
            asort($jars);
            function byname($a, $b) { return strnatcasecmp($a['name'], $b['name']); }
            uasort($jars, 'byname');
        }
        return $jars;
    }

    public function actionDismiss($id)
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400, Yii::t('mc', 'Invalid request.'));
        $id = (int)$id;
        $sql = 'delete from `move_status` where `server_id`=?';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $cmd->bindValue(1, $id);
        $cmd->execute();
        $this->redirect(array('view','id'=>$id));
    }

    public function actionSuspend($id, $stop = 1)
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400, Yii::t('mc', 'Invalid request.'));
        $model = $this->loadModel($id);
        if (Yii::app()->params['demo_mode'] == 'enabled')
        {
            Yii::app()->user->setFlash('server', Yii::t('mc', 'Function disabled in demo mode.'));
        }
        else if (!$model->suspend())
        {
            Yii::app()->user->setFlash('server', Yii::t('mc', 'Server suspend failed: ')
                .CHtml::errorSummary($model));
        }
        else
        {
            if ($stop)
                McBridge::get()->serverCmd($model->id, 'stop');
            Yii::app()->user->setFlash('server', Yii::t('mc', 'Server suspended'));
        }
        $this->redirect(array('view','id'=>$model->id));
    }

    public function actionResume($id, $start = 1)
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400, Yii::t('mc', 'Invalid request.'));
        $model = $this->loadModel($id);
        if (!$model->resume())
        {
            Yii::app()->user->setFlash('server', Yii::t('mc', 'Server resume failed: ')
                .CHtml::errorSummary($model));
        }
        else
        {
            if ($start)
                McBridge::get()->serverCmd($model->id, 'start');
            Yii::app()->user->setFlash('server', Yii::t('mc', 'Server resumed'));
        }
        $this->redirect(array('view','id'=>$model->id));
    }

    public function handleButtons($id)
    {
        $id = (int)$id;
        switch ($_POST['ajax'])
        {
        case 'start':
            if (Yii::app()->user->can($id, 'start'))
            {
                if (!McBridge::get()->serverCmd($id, 'start'))
                    echo McBridge::get()->lastError();
            }
            break;
        case 'stop':
            if (Yii::app()->user->can($id, 'stop'))
            {
                if (!McBridge::get()->serverCmd($id, 'stop'))
                    echo McBridge::get()->lastError();
            }
            break;
        case 'restart':
            if (Yii::app()->user->can($id, 'restart'))
            {
                if (!McBridge::get()->serverCmd($id, 'restart'))
                    echo McBridge::get()->lastError();
            }
            break;
        case 'kill':
            $kill = Yii::app()->params['kill_button'];
            if ($kill && ((Yii::app()->user->isStaff() && in_array($kill, array('superuser', 'user'))) || ($kill == 'user'))
                && Yii::app()->user->can($id, 'stop'))
            {
                if (!McBridge::get()->serverCmd($id, 'kill'))
                    echo McBridge::get()->lastError();
            }
            break;
        default:
            return;
        }
        Yii::app()->end();
    }

    public function actionView($id)
    {
        Yii::app()->user->can($id, 'view', true);
        $model = $this->loadModel($id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!$settings)
        {
            $settings = new ServerConfig;
            $settings->server_id = $model->id;
        }
        //$this->performAjaxValidation(array($model, $settings));

        $edit = Yii::app()->user->can($model->id, 'edit');

        $all = array('players', 'buttons', 'status', 'resources', 'movestatus');
        if (isset($_POST['ajax']))
        {
            $this->handleButtons($model->id);
            switch ($_POST['ajax'])
            {
            case 'refresh':
                header('Content-type: application/json');
                echo CJSON::encode($this->ajaxRefresh($model, $all));
                break;
            case 'kick':
                if (Yii::app()->user->can($model->id, 'kick'))
                {
                    $player = @$_POST['player'];
                    if ($player)
                    {
                        if (!McBridge::get()->serverCmd($model->id, 'mc:kick '.preg_replace("/\n/", '', $player)))
                            echo McBridge::get()->lastError();
                    }
                }
                break;
            case 'run_repairtool':
                if (!Yii::app()->params['show_repairtool'] || Yii::app()->params['show_repairtool'] == 'none')
                    break;
                if (Yii::app()->user->isStaff() || ($edit && Yii::app()->params['show_repairtool'] == 'user'))
                {
                    if (!McBridge::get()->serverCmd($model->id, 'start repairtool.jar'))
                        echo McBridge::get()->lastError();
                    else
                        echo Yii::t('mc', 'Command sent, please check the server console for details');
                }
                break;
            case 'accept_eula':
                if (Yii::app()->user->can($model->id, 'edit') && !McBridge::get()->serverCmd($model->id, 'accept_eula'))
                    echo McBridge::get()->lastError();
                break;
            }
            Yii::app()->end();
        }

        $jars = false;
        if ($edit && ($settings->user_jar || Yii::app()->user->isStaff()))
            $jars = $this->listJars($model->id);

        $adv = false;
        if (Yii::app()->user->isStaff())
            $model->sendData = isset($_POST['Server']['sendData']) ? $_POST['Server']['sendData'] : true;
        if(isset($_POST['Server']) && $edit)
        {
            $name = isset($_POST['Server']['name']) ? $_POST['Server']['name'] : false;
            $players = isset($_POST['Server']['players']) ? $_POST['Server']['players'] : false;
            $jardir = isset($_POST['Server']['jardir']) ? $_POST['Server']['jardir'] : false;
            $memory = isset($_POST['Server']['memory']) ? $_POST['Server']['memory'] : false;
            $crashCheck = isset($_POST['Server']['crash_check']) ? $_POST['Server']['crash_check'] : false;
            $subdomain = isset($_POST['Server']['domain']) ? $_POST['Server']['domain'] : false;
            if (strlen($subdomain))
            {
                $subdomain .= '.'.(isset($_POST['subdomain_domain']) ? $_POST['subdomain_domain']
                    : Yii::app()->params['user_subdomains_domain']);
            }
            if (Yii::app()->user->isStaff())
            {
                $model->scenario = 'superuser';
                $settings->scenario = 'superuser';
                $user = User::model()->findByAttributes(array('name'=>$_POST['owner-name']));
                if (!$user && @strlen($_POST['owner-name']))
                    $model->addError('owner', Yii::t('mc', 'User not found'));
                if ($model->id && $user)
                    $user->setServerFtpAccess($model->id, 'rw');
            }
            else
            {
                if (!$settings->user_name)
                    $name = $model->name;
                if (!$settings->user_players)
                    $players = $model->players;
                if (!$settings->user_jardir)
                    $jardir = $model->jardir;
                if (!$settings->user_memory)
                    $memory = $model->memory;
                if (!$settings->user_crash_check)
                    $crashCheck = $model->crash_check;
                if (!$settings->user_subdomain)
                    $subdomain = $model->domain;
                if ($settings->user_schedule)
                    $model->autosave = $_POST['Server']['autosave'];
                if ($settings->user_visibility)
                {
                    $model->default_level = $_POST['Server']['default_level'];
                    $settings->visible = $_POST['ServerConfig']['visible'];
                }
            }
            $model->attributes = $_POST['Server'];
            if ($name !== false)
                $model->name = $name;
            if ($players !== false)
                $model->players = $players;
            if ($jardir !== false)
                $model->jardir = $jardir;
            if ($memory !== false)
                $model->memory = $memory;
            if ($crashCheck !== false)
                $model->crash_check = $crashCheck;
            if ($subdomain !== false)
                $model->domain = $subdomain;
            if (Yii::app()->user->isStaff() || ($settings->user_jar && in_array($model->jardir, array('server', 'server_base'))))
            {
                if (isset($_POST['Server']['jarfile']))
                    $model->jarfile = $_POST['Server']['jarfile'];
            }
            else if ($jars && $settings->user_jar && isset($_POST['jar-select']))
            {
                $jar = $_POST['jar-select'];
                //Accept the change if the selected value is valid and either a new value was selected
                //or the default was selected and the previous value was valid. This prevents overwriting
                //a custom (i.e. invalid) JAR entered by the admin when the user doesn't change the JAR from "Default"
                if (in_array($jar, array_keys($jars)) && ($jar || in_array($model->jarfile, array_keys($jars))))
                    $model->jarfile = $jar;
            }
            $settings->attributes = @$_POST['ServerConfig'];
            $settings->give_role = @$_POST['cheat_role'];
            $settings->tp_role = $settings->give_role;
            $adminLevel = User::getRoleLevel('admin'); 
            //Limit default role
            if (User::getRoleLevel($model->default_level) >= $adminLevel)
                $settings->default_level = User::getRoleLevel('guest');
            //Limit IP auth role
            if (User::getRoleLevel($settings->ip_auth_role) >= $adminLevel)
                $settings->ip_auth_role = '';
            if($model->validate(null, false) && $settings->validate() && $model->save(false))
            {
                $settings->save(false);
                if (Yii::app()->user->isStaff())
                {
                    $ownerId = $user ? $user->id : 0;
                    if ($ownerId != $model->owner)
                        $model->setOwner($user);
                }
                Yii::log('Updated server '.$model->id);
                Yii::app()->user->setFlash('server', Yii::t('mc', 'Server settings saved.'));
                $moveTo = (int)@$_POST['move_files'];
                if ($moveTo)
                    McBridge::get()->cmd($model->daemon_id, 'server '.$model->id.':migrate '.$moveTo);
                if (@$_POST['goto_setup'] != '')
                    $this->redirect(array('setup','id'=>$model->id, 'tplSuggest'=>$_POST['goto_setup']));
                else
                    $this->redirect(array('view','id'=>$model->id));
            }
            else
                $adv = true;
        }

        $my = array();
        if (!Yii::app()->user->isGuest && !Yii::app()->user->isStaff())
        {
            $cmd = Yii::app()->db->createCommand($this->ownServerSql);
            $cmd->bindValue(1, (int)Yii::app()->user->id);
            $ids = $cmd->queryColumn();
            $myModels = array();
            if (count($ids) > 1 && in_array($model->id, $ids))
                $myModels = Server::model()->findAllByAttributes(array('id'=>array_values($ids),), array('order'=>'lower(name) asc'));
            foreach ($myModels as $myModel)
                $my[$myModel->id] = substr($myModel->name, 0, 40).' ('.User::getRoleLabel(Yii::app()->user->model->getServerRole($myModel->id)).')';
        }

        $editConfigs = Yii::app()->user->can($model->id, 'edit_configs');
        $plugins = Yii::app()->user->can($model->id, 'manage_plugins');
        $manageUsers = Yii::app()->user->can($model->id, 'manage_users');
        $schedule = ((Yii::app()->user->isStaff() || $settings->user_schedule) && Yii::app()->user->can($model->id, 'manage_schedule'));
        $mysql = @strlen($model->mysqlHost) && ((Yii::app()->params['user_mysql'] && $settings->user_mysql) || Yii::app()->user->isStaff()) && Yii::app()->user->can($model->id, 'manage_mysql');
        $pluginList = Yii::app()->params['use_pluginlist'] && $plugins;
        $templates = (Yii::app()->params['templates_disabled'] !== true)
            && ($settings->user_templates || Yii::app()->user->isStaff()) && Yii::app()->user->can($model->id, 'manage_templates');
        $params = ($settings->user_params || Yii::app()->user->isStaff()) && Yii::app()->user->can($model->id, 'manage_params');
        $ports = Yii::app()->params['additional_ports']
            && ((isset($settings->user_add_ports) && $settings->user_add_ports) || Yii::app()->user->isStaff())
            && Yii::app()->user->can($model->id, 'edit');
        if (!$plugins || !McBridge::get()->serverCmd($model->id, 'plugin has', $data) || !@$data[0]['has'])
            $localPlugins = false;
        else
            $localPlugins = true;
        $model->domain = explode('.', $model->domain, 2);
        $domain = ''.@$model->domain[1];
        $model->domain = ''.@$model->domain[0];
        $backup = (!@Yii::app()->params['backup_world_disable'] || @Yii::app()->params['backup_full']) && Yii::app()->user->can($model->id, 'get_backup');

        $this->render('view',array(
            'model'=>$model,
            'settings'=>$settings,
            'chat'=>Yii::app()->user->can($model->id, 'chat'),
            'viewLog'=>Yii::app()->user->can($model->id, 'get_log'),
            'getPlayers'=>Yii::app()->user->can($model->id, 'get_players'),
            'editConfigs'=>$editConfigs,
            'manageUsers'=>$manageUsers,
            'manageCommands'=>Yii::app()->user->can($model->id, 'manage_commands'),
            'managePlayers'=>Yii::app()->user->can($model->id, 'manage_players'),
            'edit'=>$edit,
            'delete'=>Yii::app()->user->isSuperuser(),
            'buttons'=>Yii::app()->user->can($model->id, 'start'),
            'backup'=>$backup,
            'command'=>Yii::app()->user->can($model->id, 'command'),
            'jars'=>$jars,
            'data'=>$this->ajaxRefresh($model, $all),
            'advanced'=>$adv,
            'my'=>$my,
            'localPlugins'=>$localPlugins,
            'pluginList'=>$pluginList,
            'mysql'=>$mysql,
            'templates'=>$templates,
            'params'=>$params,
            'schedule'=>$schedule,
            'domain'=>$domain,
            'ports'=>$ports,
        ));
    }

    public function actionCreate()
    {
        $model = new Server('superuser');
        $settings = new ServerConfig('superuser');
        $this->performAjaxValidation($model);
        $adv = false;
        $model->sendData = isset($_POST['Server']['sendData']) ? $_POST['Server']['sendData'] : true;
        if(isset($_POST['Server']))
        {
            $model->attributes=$_POST['Server'];
            $settings->attributes=$_POST['ServerConfig'];
            $settings->give_role = @$_POST['cheat_role'];
            $settings->tp_role = @$_POST['cheat_role'];
            $user = User::model()->findByAttributes(array('name'=>$_POST['owner-name']));
            if (!$user && @strlen($_POST['owner-name']))
                $model->addError('owner', Yii::t('mc', 'User not found'));
            if($model->validate(null, false) && $settings->validate())
            {
                $model->save(false);
                $settings->server_id = $model->id;
                $settings->scenario = 'create';
                $settings->save(false);
                Yii::log('Created server '.$model->id);
                $model->setOwner($user);
                if ($user && $model->id)
                    $user->setServerFtpAccess($model->id, 'rw');
                $model->createDefaultCommands();
                McBridge::get()->serverCmd($model->id, 'run_s:builtin:script setup');
                $this->redirect(array('view','id'=>$model->id));
            }
            else
                $adv = true;
        }
        $this->render('view',array(
            'model'=>$model,
            'settings'=>$settings,
            'edit'=>true,
            'jars'=>$this->listJars(),
            'advanced'=>$adv,
            'my'=>false,
            'domain'=>'',
        ));
    }

    public function actionUsers($id)
    {
        Yii::app()->user->can($id, 'manage_users', true);
        $model = $this->loadModel($id);
        $myRole = Yii::app()->user->serverRole($model->id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!$settings || !$settings->user_ftp)
            $userFtp = false;
        else
            $userFtp = true;
        $userFtp = Yii::app()->user->isStaff() || (Yii::app()->user->can($id, 'manage_ftp') && $userFtp);
        if (isset($_POST['ajax']))
        {
            if ($_POST['ajax'] == 'role')
            {
                $role = @$_POST['role'];
                $user = (int)@$_POST['user'];
                if ($role === '')
                {} // Valid role, unassign
                else if ($role == $myRole // Can't assign own role
                    || !in_array($role, User::$roles) // Not a valid role
                    || $role == User::$roles[count(User::$roles)-1] // Can't assign Owner role
                    || User::getRoleLevel($myRole) <= User::getRoleLevel($role)) // Can't assign roles greater than own
                    die(Yii::t('mc', 'Invalid role selected.'));
                $user = User::model()->findByPk($user);
                if (!$user)
                    die(Yii::t('mc', 'Invalid user selected.'));
                if (User::getRoleLevel($myRole) <= $user->getLevel($model->id))
                    die(Yii::t('mc', 'No permission to change that user.'));
                Yii::log('Setting user role of user '.$user->id.' for server '.$model->id.' to '.$role);
                if (!$user->setServerRole($model->id, $role))
                    die(Yii::t('mc', 'Failed to change user role!'));
            }
            else if ($_POST['ajax'] == 'ftpAccess' && $userFtp)
            {
                $access = $_POST['ftpAccess'];
                $user = (int)$_POST['user'];
                $user = User::model()->findByPk($user);
                if (!$user)
                    die(Yii::t('mc', 'Invalid user selected.'));
                Yii::log('Setting FTP access of user '.$user->id.' for server '.$model->id.' to '.$access);
                if (!$model->id || !$user->setServerFtpAccess($model->id, $access))
                    die(Yii::t('mc', 'Failed to change user role!'));
            }
            Yii::app()->end();
        }
        Yii::app()->params['view_server_id'] = $model->id;
        Yii::app()->params['view_role'] = $myRole;
        $users = new User('search');
        $users->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $users->attributes=$_GET['User'];

        $provider = $users->search();
        //hide list enabled and not superuser
        if (((Yii::app()->params['hide_userlist'] === true) && !Yii::app()->user->isStaff() || @$_GET['roles_only'] == 1)
            && (strlen($users->name) < 2 || $users->name[0] != '=')) //not requesting exact match
        {
            $cond = '((select `role` from `user_server` where `server_id`='.((int)$model->id)
                .' and `user_id`=`id`)!=\'\' or `name`=:name)';
            $provider->criteria->params[':name'] = $users->name;
            $provider->criteria->addCondition($cond);
        }

        $this->render('users',array(
            'model'=>$model,
            'provider'=>$provider,
            'users'=>$users,
            'userFtp'=>$userFtp,
        ));
    }

    private function replData($str, $file, $dir)
    {
        $str = preg_replace('/{file}/', $file, $str);
        $str = preg_replace('/{dir}/', $dir, $str);
        return $str;
    }

    public function actionConfigs($id)
    {
        Yii::app()->user->can($id, 'edit_configs', true);
        $configs = ConfigFile::model()->findAll();
        $model = $this->loadModel($id);
        $dmn = Server::getDaemon($model->id);

        $list = array();
        $error = '';
        foreach ($configs as $cfg)
        {
            if (!$cfg->enabled)
                continue;
            $res = McBridge::get()->cmd($dmn, 'server '.$model->id.':cfgfile check:'.$cfg->file.':'.$cfg->dir.':');
            if (!$res['success'] || !isset($res['data'][0]))
            {
                $error = CHtml::encode($res['error']);
                continue;
            }
            foreach ($res['data'] as $data)
            {
                if ($data['valid'] != 'True')
                    continue;

                $name = $this->replData($cfg->name, $data['file'], $data['dir']);
                $desc = $this->replData($cfg->description, $data['file'], $data['dir']);
                $list[] = array('id'=>$cfg->id, 'name'=>$name, 'desc'=>$desc, 'ro'=>$data['ro'],
                    'file'=>$data['file'], 'dir'=>$data['dir'],
                    'action'=>$data['ro'] == 'True' ? 'View' : 'Edit');
            }                
        }

        $perm = McBridge::get()->cmd($dmn, 'server '.$model->id.':cfgfile check:[Pp]ermissions.[Jj][Aa][Rr]:plugins/:');
        if ($perm['success'] && isset($perm['data'][0]))
            $perm = true;
        else
            $perm = false;

    
        $this->render('configs',array(
            'dataProvider'=> new CArrayDataProvider($list, array(
                'sort'=>array(
                    'attributes'=>array(
                        'name', 'file',
                    ),
                ),
                'pagination'=>array('pageSize'=>10),
            )),
            'model'=>$model,
            'error'=>$error,
            'perm'=>$perm,
        ));
    }

    public function genSelect($select, $value)
    {
        if ($select !== 'bool')
            return $select;
        $types = array('true', 'false', 'on', 'off', 'yes', 'no');
        $idx = intval(array_search($value, $types));
        $idx -= ($idx % 2);
        return array($types[$idx]=>Yii::t('mc', 'Enabled'), $types[$idx + 1]=>Yii::t('mc', 'Disabled'));
    }

    public function actionEditConfig($id, $config, $ro, $file, $dir)
    {
        Yii::app()->user->can($id, 'edit_configs', true);
        $model = $this->loadModel($id);
        $cfg = ConfigFile::model()->findByPk($config);

        if (!$cfg || !preg_match('/'.$cfg->file.'/', $file))
            throw new CHttpException(404, Yii::t('mc', 'Config file not found'));

        if (preg_match('/^load:[-_a-zA-Z0-9]+$/', $cfg->options))
        {
            $fileName = substr($cfg->options, strlen('load:')).'.conf';
            $path = dirname(__FILE__).'/../data/'.$fileName;
            $rules = CJSON::decode(@file_get_contents($path));
        }
        else            
            $rules = CJSON::decode($cfg->options);

        $ro = ($ro == Yii::t('mc', 'True') ? true : false);

        $error = false;
        $name = $this->replData($cfg->name, $file, $dir);

        if (!$ro && @$_POST['save'] === 'true')
        {
            $data = '';
            if ($cfg->type == 'properties')
            {
                $acceptAll = @$rules['*']['visible'] ? true : false;

                if (@count($_POST['option']))
                foreach ($_POST['option'] as $opt=>$val)
                {
                    if ($acceptAll || !isset($rules[$opt]['visible']) || $rules[$opt]['visible'])
                        $data .= $opt.'='.$val."\n";
                }
                
            }
            else
                $data = $_POST['list'];
            $data = $data ? str_replace(array('\\', ' ;'), array('\\\\', ' \;'), $data) : '';
            $data = preg_replace('/\n\r?/', ' ;', $data);
            $d = null;
            if (!McBridge::get()->serverCmd($model->id, 'cfgfile set'.$cfg->type.':'.$file.':'.$dir.':'.$data, $d))
                $error = McBridge::get()->lastError();
            else if (@$d[0]['accepted'] != 'True')
            {
                $error = isset($d[0]['message']) ? $d[0]['message'] : Yii::t('mc', 'Error updating config file!');
            }
            else
            {
                Yii::app()->user->setFlash('server', Yii::t('mc', 'Config File saved.'));
                $this->redirect(array('configs','id'=>$model->id));
            }
        }

        $data = null;
        if (!McBridge::get()->serverCmd($model->id, 'cfgfile get'.$cfg->type.':'.$file.':'.$dir.':', $data))
            $error = McBridge::get()->lastError();

        $opts = array();
        $list = '';

        if ($data && $cfg->type == 'properties')
        {
            if (@is_array($rules))
            foreach ($rules as $match=>$info)
            {
                $found = false;
                foreach ($data as $k=>$v)
                {
                    $opt = array();
                    $opt['name'] = $v['option'];
                    $opt['value'] = $v['value'];
                    $opt['visible'] = true;
                    
                    if (strlen($opt['name']) && $match != '*' && $match != $opt['name'])
                        continue;

                    $found = true;
                    if (isset($info['visible']))
                        $opt['visible'] = $info['visible'];
                    if (isset($info['name']))
                        $opt['name'] = $info['name'];
                    if (isset($info['select']))
                        $opt['select'] = $this->genSelect($info['select'], $opt['value']);
                    if (isset($info['default']) && !strlen($opt['value']))
                        $opt['value'] = $info['default'];

                    if ($opt['visible'])
                        $opts[$v['option']] = $opt;

                    if ($match != '*')
                    {
                        unset($data[$k]);
                        break;
                    }
                }
                if (!$found && $match != '*' && !@$info['nocreate'] && (!isset($info['visible']) || $info['visible']))
                {
                    $opts[$match] = $info;
                    if (!@$opts[$match]['name'])
                        $opts[$match]['name'] = $match;
                    $opts[$match]['value'] = @$info['default'];
                    if (isset($info['select']))
                        $opts[$match]['select'] = $this->genSelect($info['select'], @$info['default']);
                }
            }
        }
        else if ($data)
        {
            foreach ($data as $line)
                if (isset($line['line']))
                    $list .= $line['line']."\n";            
        }

        $this->render('editConfig',array(
            'dataProvider'=> new CArrayDataProvider($data, array(
                'sort'=>array(
                    'attributes'=>array(
                        'name', 
                    ),
                ),
                'pagination'=>array('pageSize'=>10),
            )),
            'type'=>$cfg->type,
            'list'=>$list,
            'options'=>$opts,
            'name'=>$name,
            'model'=>$model,
            'error'=>$error,
            'ro'=>$ro,
        ));
    }

    private function getRolePerms($role, $default, $prefix, $suffix, $build, $perms)
    {
        $perms = array_filter(array_map('trim', explode(',', $perms)));
        return array(
            'default'=>$default,
            'info'=>array(
                'prefix'=>$prefix,
                'suffix'=>$suffix,
                'build'=>$build,
            ),
            'permissions'=>$perms,
        );
    }

    public function toYmlStr($a)
    {
        if (is_array($a))
            return (count($a) ? strval($a[0]) : '');
        return strval($a);
    }

    public function actionEditPermissionsConfig($id)
    {
        Yii::app()->user->can($id, 'edit_configs', true);
        $model = $this->loadModel($id);
        $error = '';
        $world = $model->world ? $model->world : 'world';
        if (@$_POST['save'] === 'true')
        {
            require_once(dirname(__FILE__).'/../extensions/spyc/spyc.php');
            $groups['groups'] = array();
            $def = User::getLevelRole($model->default_level);
            $prev = false;
            foreach (User::$roles as $role)
            {
                if ($role == 'none')
                    continue;
                $lbl = $role;//User::getRoleLabel($role);
                $groups['groups'][$lbl] = $this->getRolePerms($role, $role == $def,$_POST['prefix_'.$role],
                    $_POST['suffix_'.$role], $_POST['build_'.$role] == 0, $_POST['perms_'.$role]);
                if ($prev)
                    $groups['groups'][$lbl]['inheritance'] = array($prev);
                $prev = $lbl;
            }
            $plrs = Player::model()->findAllByAttributes(array('server_id'=>$model->id));
            $users['users'] = array();
            foreach ($plrs as $plr)
            {
                $users['users'][$plr->name] = array('groups'=>array(User::getLevelRole($plr->level)));
            }
            $groups = Spyc::YAMLDump($groups, 4, 0);
            $users = Spyc::YAMLDump($users, 4, 0);

            $groupsData = $groups ? str_replace(array('\\', ' ;'), array('\\\\', ' \;'), $groups) : '';
            $groupsData = preg_replace('/\n\r?/', ' ;', $groupsData);
            $usersData = $users ? str_replace(array('\\', ' ;'), array('\\\\', ' \;'), $users) : '';
            $usersData = preg_replace('/\n\r?/', ' ;', $usersData);
            $d = null;
            if (!McBridge::get()->serverCmd($model->id, 'cfgfile setlist:groups.yml:plugins/Permissions/'.$world.':'.$groupsData, $d))
                $error = McBridge::get()->lastError();
            else if (@$d[0]['accepted'] != 'True')
            {
                $error = isset($d[0]['message']) ? $d[0]['message'] : Yii::t('mc', 'Error updating config file!');
            }
            else if (!McBridge::get()->serverCmd($model->id, 'cfgfile setlist:users.yml:plugins/Permissions/'.$world.':'.$usersData, $d))
                $error = McBridge::get()->lastError();
            else if (@$d[0]['accepted'] != 'True')
            {
                $error = isset($d[0]['message']) ? $d[0]['message'] : Yii::t('mc', 'Error updating config file!');
            }
            else
            {
                Yii::app()->user->setFlash('server', Yii::t('mc', 'Config File saved.'));
                $this->redirect(array('configs','id'=>$model->id));
            }
        }
        else
        {
            require_once(dirname(__FILE__).'/../extensions/spyc/spyc.php');
            $groupsData = array();
            $usersData = array();
            if (!McBridge::get()->serverCmd($model->id, 'cfgfile getlist:groups.yml:plugins/Permissions/'.$world.':', $groupsData))
                $error = McBridge::get()->lastError();
            if (!McBridge::get()->serverCmd($model->id, 'cfgfile getlist:users.yml:plugins/Permissions/'.$world.':', $usersData))
                $error = McBridge::get()->lastError();
            $users = '';
            $groups = '';
            if (count($groupsData))
            foreach ($groupsData as $line)
                if (isset($line['line']))
                    $groups .= $line['line']."\n";
            if (count($usersData))
            foreach ($usersData as $line)
                if (isset($line['line']))
                    $users .= $line['line']."\n";
            $groups = Spyc::YAMLLoadString($groups);
            foreach (User::$roles as $role)
            {
                if ($role == 'none')
                    continue;
                $lbl = $role;//User::getRoleLabel($role);
                $_POST['prefix_'.$role] = @$groups['groups'][$lbl]['info']['prefix'];
                $_POST['suffix_'.$role] = @$groups['groups'][$lbl]['info']['suffix'];
                $_POST['build_'.$role] = isset($groups['groups'][$lbl]['info']['build']) && !$groups['groups'][$lbl]['info']['build'] ? 1 : 0;
                if (isset($groups['groups'][$lbl]['permissions'][0]) && $groups['groups'][$lbl]['permissions'][0])
                    $_POST['perms_'.$role] = implode(', ', array_map(array($this, 'toYmlStr'), $groups['groups'][$lbl]['permissions']));
            }
        }

        $this->render('editPermissionsConfig',array(
            'model'=>$model,
            'error'=>$error,
        ));
    }

    public function actionPluginList($id, $installed = false)
    {
        if (Yii::app()->params['use_pluginlist'] !== true)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        Yii::app()->user->can($id, 'manage_plugins', true);

        $plugins = new ServerPlugin('search');
        $plugins->unsetAttributes();
        if(isset($_GET['ServerPlugin']))
            $plugins->attributes=$_GET['ServerPlugin'];

        $srcs = $plugins->sources;
        if (!is_array($srcs) || !count($srcs))
            throw new CHttpException(500, Yii::t('mc', 'No plugin sources found'));
        $srcs = CHtml::listData($srcs, 'id', 'name');
            
        $plugins->source_id = @$_GET['source_id'];
        if (!$plugins->source_id)
            $plugins->source_id = Yii::app()->user->getState(intval($id).'_plugin_source_id');
        else
            Yii::app()->user->setState(intval($id).'_plugin_source_id', $plugins->source_id);
        $srcIds = array_keys($srcs);
        if (!in_array($plugins->source_id, $srcIds))
            $plugins->source_id = $srcIds[0];

        $cats = $plugins->allCategories;

        $cmd = ServerPlugin::model()->getDbConnection()->createCommand('select distinct `stage` from `plugin` where `source_id`=?');
        $allStatus = $cmd->queryColumn(array($plugins->source_id));

        $plugins->categories = @$_GET['cat'];
        if (!$plugins->checkCategory($plugins->categories))
            $plugins->categories = '';

        $plugins->checkPlugins();

        $this->render('pluginList',array(
            'model'=>$this->loadModel($id),
            'cats'=>$cats,
            'srcs'=>$srcs,
            'plugins'=>$plugins,
            'installed'=>$installed,
            'allStatus'=>$allStatus,
        ));
    }

    public function actionPlugin($id, $source_id, $plugin_id, $installed = false, $action = '')
    {
        if (Yii::app()->params['use_pluginlist'] !== true)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        Yii::app()->user->can($id, 'manage_plugins', true);
        $model = $this->loadModel($id);
        $plugin = ServerPlugin::model()->findByAttributes(array('source_id'=>$source_id, 'id'=>$plugin_id));
        if (!$plugin)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        $plugin->complete();

        $version = '';
        $status = '';

        $info = ServerPluginInfo::model()->findByPk(array('server_id'=>$model->id, 'name'=>$plugin->infoName));
        if (!$info && in_array($source_id, array('bukkit', 'bukget'))) //compatibility
            $info = ServerPluginInfo::model()->findByPk(array('server_id'=>$model->id, 'name'=>$plugin->id));
        if ($info)
        {
            $info->plugin = $plugin;
            if ($info->installed)
            {
                $status = $info->installed;
                $version = $info->version;
            }
        }

        if (isset($_POST['ajax']))
        {
            switch ($_POST['ajax'])
            {
            case 'get_status':
                header('Content-type: application/json');
                echo CJSON::encode(array('status'=>CHtml::encode($status), 'version'=>CHtml::encode($version)));
                break;
            case 'install':
            case 'update':
                $version = @$_POST['version'];
                $versions = $plugin->getVersions();
                if (!isset($versions[$version]))
                    die(Yii::t('mc', 'Invalid version selected'));
                if (!McBridge::get()->serverCmd($model->id, 'xplugin install:'.CJSON::encode(array(
                    'name'=>$info ? $info->name : $plugin->infoName,
                    'filename'=>$versions[$version]['filename'],
                    'version'=>$version,
                    'download'=>$versions[$version]['download']
                ))))
                {
                    die(Yii::t('mc', 'Failed to {action} plugin', array('{action}'=>$_POST['ajax'])).': '
                        .McBridge::get()->lastError());
                }
                break;
            case 'remove':
            case 'enable':
            case 'disable':
                if (!McBridge::get()->serverCmd($model->id, 'xplugin '.$_POST['ajax'].':'.CJSON::encode(array(
                    'name'=>$info ? $info->name : $plugin->infoName,
                ))))
                {
                    die(Yii::t('mc', 'Failed to {action} plugin', array('{action}'=>$_POST['ajax'])).': '
                        .McBridge::get()->lastError());
                }
                break;
            }
            Yii::app()->end();
        }

        $cmd = ServerPlugin::model()->getDbConnection()->createCommand('select `name` from `source` where `id`=?');
        $source = $cmd->queryScalar(array($plugin->source_id));

        $this->render('plugin',array(
            'model'=>$model,
            'plugin'=>$plugin,
            'info'=>$info,
            'installed'=>$installed,
            'action'=>$action,
            'status'=>$status,
            'version'=>$version,
            'source'=>$source,
        ));
    }

    public function actionLocalPlugins($id)
    {
        Yii::app()->user->can($id, 'manage_plugins', true);
        $model = $this->loadModel($id);

        if (isset($_POST['action']))
        {
            switch ($_POST['action'])
            {
            case 'unpack':
            case 'install':
                if (!McBridge::get()->serverCmd($model->id, 'plugin add:'.$_POST['file']))
                {
                    Yii::app()->user->setFlash('server',
                        Yii::t('mc', 'Failed to install plugin').': '.CHtml::encode(McBridge::get()->lastError()));
                }
                if ($_POST['action'] == 'unpack')
                {
                    Yii::app()->user->setFlash('plugin_unpack',
                        Yii::t('mc', 'The plugin archive is being unpacked, please see the server log.'));
                }
                break;
            case 'remove':
                if (!McBridge::get()->serverCmd($model->id, 'plugin remove:'.$_POST['file']))
                {
                    Yii::app()->user->setFlash('server',
                        Yii::t('mc', 'Failed to remove plugin').': '.CHtml::encode(McBridge::get()->lastError()));
                }
                break;
            }
            $this->redirect(array_merge(array('localPlugins', 'id'=>$model->id), $_GET));
        }

        $filter = new PluginFilter;
        $filter->unsetAttributes();
        if(isset($_GET['PluginFilter']))
            $filter->attributes = $_GET['PluginFilter'];
        $filter->prepareFilters();

        $list = array();
        $error = '';
        $data = array();
        $haveItems = false;
        if (!McBridge::get()->serverCmd($model->id, 'plugin list', $data))
            Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
        else
        {
            $haveItems = count($data);
            $purifier = new CHtmlPurifier();
            foreach ($data as $d)
            {
                $st = array(
                    'installed'=>array(Yii::t('mc', 'Installed'), array('remove'=>Yii::t('mc', 'Remove'))),
                    'outdated'=>array(Yii::t('mc', 'Outdated'), array('install'=>Yii::t('mc', 'Update'), 'remove'=>Yii::t('mc', 'Remove'))),
                    'none'=>array(Yii::t('mc', 'Not Installed'), array('install'=>Yii::t('mc', 'Install'))),
                );
                $l = array('id'=>1, 'file'=>strtolower($d['file']), 'desc'=>$purifier->purify($d['desc']),
                    'status'=>$d['status']);
                if (!$filter->filter($l) || !isset($st[$l['status']]))
                    continue;
                $actions = '';
                foreach ($st[$d['status']][1] as $action=>$label)
                {
                    if (preg_match('/\.zip$/i', $d['file']))
                    {
                        $label = Yii::t('mc', 'Unpack');
                        $action = 'unpack';
                        $l['status'] = '';
                    }
                    $actions .= CHtml::link(CHtml::encode($label), '#', array(
                        'submit'=>array_merge(array('localPlugins', 'id'=>$model->id), $_GET),
                        'params'=>array('file'=>$d['file'], 'action'=>$action),
                        'csrf'=>true,
                    )).' ';
                }
                if ($l['status'])
                    $l['status'] = '_'.$l['status'];
                else
                    $l['status'] = '';
                $l['status_alt'] = @$st[$d['status']][0];
                $l['action'] = $actions;
                $l['displayFile'] = $d['file'];
                $list[] = $l;
            }                
        }

    
        $this->render('localPlugins',array(
            'dataProvider'=> new CArrayDataProvider($list, array(
                'sort'=>array(
                    'attributes'=>array(
                        'file',
                        'status',
                    ),
                    'defaultOrder'=>array('file'=>CSort::SORT_ASC),
                ),
                'pagination'=>array('pageSize'=>10),
            )),
            'filter'=>$filter,
            'haveItems'=>$haveItems,
            'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        $canDel = false;
        $shared = Server::model()->findAllByAttributes(array('daemon_id'=>$model->daemon_id, 'dir'=>$model->dir));
        $cmd = Yii::app()->db->createCommand('select `server_id` from `user_server` where `role`=\'owner\' and `user_id`=?');
        $cmd->execute(array($model->owner));
        $us = $cmd->queryColumn();
        $owned = Server::model()->findAllByAttributes(array('id'=>$us));

        if(@$_POST['delete'] === 'true')
        {
            if (isset($_POST['del_files']))
            {
                if (!in_array($_POST['del_files'], array(Yii::t('mc', 'yes'), Yii::t('mc', 'no'))))
                {
                    Yii::app()->user->setFlash('server', Yii::t('mc', 'Please enter "{yes}" or "{no}"',
                        array('{yes}'=>Yii::t('mc', 'yes'), '{no}'=>Yii::t('mc', 'no')))
                    );
                    $this->redirect(array('delete', 'id'=>$model->id));
                }
                if (strtolower($_POST['del_files']) === Yii::t('mc', 'yes'))
                    $model->deleteDir = 'yes';
            }

            $owner = $model->owner;
            //delete server, then delete user
            Yii::log('Deleting server '.$model->id.' (delete dir: '.$model->deleteDir.')');
            if ($model->delete() && @$_POST['del_user'])
                User::model()->findByPk($owner)->delete();            

            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        if (!McBridge::get()->serverCmd($model->id, 'get status', $status))
            $status = 'error';
        else
            $status = $status[0]['status'];
        if ($status == 'stopped' && count($shared) <= 1)
            $canDel = true;
        $this->render('delete',array(
            'model'=>$model,
            'shared'=>$shared,
            'canDel'=>$canDel,
            'owned'=>$owned,
            'status'=>$status,
            'info'=>$model->dbInfo,
        ));
    }

    private function errStr($error)
    {
        return CHtml::encode($error);
    }

    private function ajaxRefresh($server, $type)
    {
        if (@Yii::app()->params['delay_daemon_queries'] && !isset($_POST['ajax']))
            return array(
                'statusicon' => Theme::themeFile('images/icons/changing.png'),
            );
        $all = ($type === 'all');
        if (!is_array($type))
            $type = array($type);
        $ret = array();

        $status = False;

        if ($all || in_array('players', $type))
        {
            $error = false;
            $players = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_players'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'get players', $players))
                $error = McBridge::get()->lastError();

            $i = 0;
            if (is_array($players) && count($players)):
                $kick = Yii::app()->user->can($server->id, 'kick');
                foreach ($players as $player):
                    
            ?>
                    <div>
                        <?php
                            $nick = '<span'.($this->ip == @$player['ip']
                                ? ' style="font-weight: bold; color: blue"' : '').'>'
                                    .CHtml::encode(@$player['name']).'</span>';
                            if (@$player['id'])
                                echo CHtml::link($nick, array('player/view', 'id'=>$player['id']));
                            else
                                echo $nick;

                        ?>
                        <?php if ($kick): ?>
                            <span style="float: right">
                                <?php echo CHtml::link('Kick', 'javascript:kickPlayer('.CJSON::encode(@$player['name']).')'); ?>
                            </span>
                        <?php endif ?>
                    </div>
            <?php
                $i++;
                endforeach;
            else:
            ?>
                <div>
                    <?php if (strlen($error))
                        echo Yii::t('mc', 'Error getting player list: ').$this->errStr($error);
                    else
                        echo Yii::t('mc', 'No players online');
                    ?>
                </div>
            <?php
            endif;
            $ret['players'] = ob_get_clean();
        }
        if ($all || in_array('chat', $type))
        {
            $error = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_chat'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'get chat', $chat))
                $error = McBridge::get()->lastError();
            if (strlen($error))
                echo Yii::t('mc', 'Couldn\'t get chat: ').$error;
            else
            {
                $lines = array();
                for($i = count($chat) - 1; $i >= 0; $i--)
                    $lines[] = @strftime('%H:%M:%S', $chat[$i]['time']).' '.str_pad('<'.$chat[$i]['name']
                            .'>', 25).$chat[$i]['text'];
                if (Yii::app()->params['log_bottomup'])
                    $lines = array_reverse($lines);
                echo implode("\n", $lines);
            }
            $ret['chat'] = ob_get_clean();
        }
        if ($all || in_array('status', $type)
                 || in_array('statusdetail', $type)
                 || in_array('statusicon', $type))
        {
            $error = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_status'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'get status', $status))
                $ret['status'] = McBridge::get()->lastError();
                
            if (strlen($error))
                echo Yii::t('mc', 'Error getting server status: ').$this->errStr($error);
            else
            {
                $ret['statusdetail'] = Yii::t('mc', 'Offline');
                $st = @$status[0];
                switch (@$st['status'])
                {
                case 'running':
                    echo Yii::t('mc', 'The server is online!');
                    $ret['statusdetail'] = Yii::t('mc', 'Online').', '.@$st['players'].'/'.@$st['maxPlayers'].' '.Yii::t('mc', 'players');
                    $ret['statusicon'] = Theme::themeFile('images/icons/online.png');
                    break;
                case 'stopped':
                    echo Yii::t('mc', 'The server is offline.');
                    $ret['statusicon'] = Theme::themeFile('images/icons/offline.png');
                    break;
                default:
                    echo Yii::t('mc', 'The server status is currently changing.');
                    $ret['statusicon'] = Theme::themeFile('images/icons/changing.png');
                }
                if (@$st['pid'] && Yii::app()->user->isStaff())
                    $ret['statusdetail'] .= ' ('.Yii::t('mc', 'PID').': '.@$st['pid'].')';
            }
            if ($server->suspended)
                $ret['statusdetail'] = Yii::t('mc', 'Suspended').' - '.$ret['statusdetail'];
            $ret['status'] = ob_get_clean();
            
        }
        if ($all || in_array('resources', $type))
        {
            $error = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_log'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'get resources', $res))
                $error = McBridge::get()->lastError();
                
            if (!strlen($error))
            {
                $st = @$res[0];
                switch (@Yii::app()->params['ram_display'])
                {
                case 'system_percent':
                    $memory = $memoryPercent = @$st['sys_memory'];
                    $memorySign = Yii::t('mc', '%');
                    break;
                case 'mb':
                    $memory = min($server->memory, @$st['memory_rss']);
                    $memorySign = Yii::t('mc', 'MB');
                    $memoryPercent = @$st['sys_memory'];
                    break;
                case 'mb_capped':
                    $memory = min($server->memory, @$st['memory_rss']);
                    $memorySign = Yii::t('mc', 'MB');
                    $memoryPercent = @$st['memory'];
                    break;
                default:
                    $memory = $memoryPercent = @$st['memory'];
                    $memorySign = Yii::t('mc', '%');
                }
                $memory = number_format($memory);
                $cpu = floatval(@$st['cpu']);
                if (@Yii::app()->params['cpu_display'] != 'core')
                {
                    $cores = max(1, intval(@$st['cores']));
                    $cpu /= $cores;
                }
                $cpu = number_format(min(100, $cpu));
                $quotaUsage = @$st['quota'];
                $this->renderPartial('resources', array(
                    'model'=>$server,
                    'pid'=>@$st['pid'],
                    'cpu'=>$cpu,
                    'memory'=>$memory,
                    'memoryPercent'=>$memoryPercent,
                    'memorySign'=>$memorySign,
                    'quotaUsage'=>$quotaUsage,
                ));
            }
            $ret['resources'] = ob_get_clean();
        }
        if ($all || in_array('log', $type))
        {
            $error = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_log'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'get_log '.((int)@$_POST['log_seq']), $log))
            {
                $error = McBridge::get()->lastError();
                if (strpos($error, 'Unknown command:') === 0)
                {
                    $error = false;
                    if (!McBridge::get()->serverCmd($server->id, 'get log', $log))
                        $error = McBridge::get()->lastError();
                }
            }

            if (strlen($error))
                echo Yii::t('mc', 'Couldn\'t get log: ').$error;
            else
            {
                for($i = count($log) - 1; $i >= 0; $i--)
                    echo @$log[$i]['line']."\n";
            }
            $ret['log'] = ob_get_clean();
            $ret['log_seq'] = @$log[count($log)-1]['s'];
        }
        if ($all || in_array('buttons', $type))
        {
            $error = false;
            ob_start();
            if (!$status)
            {
                if (!Yii::app()->user->can($server->id, 'get_status'))
                    $error = Yii::t('mc', 'Permission denied.');
                else if (!McBridge::get()->serverCmd($server->id, 'get status', $status))
                    $error = McBridge::get()->lastError();
            }
            
            $off = '1'; $on = '0';
            $b1 = $b2 = $b3 = $b4 = $off;
            if (Yii::app()->user->can($server->id, 'start'))
                $b1 = $on;
            if (Yii::app()->user->can($server->id, 'stop'))
                $b2 = $on;
            if (Yii::app()->user->can($server->id, 'restart'))
                $b3 = $on;
            if (Yii::app()->user->can($server->id, 'stop'))
                $b4 = $on;
            switch (@$status[0]['status'])
            {
            case 'running':
                $b1 = $off;
                break;
            case 'stopped':
                $b2 = $off;
                break;
            default:
                $b1 = $b3 = $off;
            }
            
            echo $b1.$b2.$b3.$b4;

            $ret['buttons'] = ob_get_clean();
        }
        if (/*$all ||*/ in_array('backup', $type))
        {
            $error = false;
            ob_start();
            if (!Yii::app()->user->can($server->id, 'get_backup'))
                $error = Yii::t('mc', 'Permission denied.');
            else if (!McBridge::get()->serverCmd($server->id, 'backup status', $backup))
                $error = McBridge::get()->lastError();
                
            $dis = array('disabled'=>'disbled');
            $start = false;
            $cls = 'flash-success';
            switch ($backup[0]['status'])
            {
            case 'none':
                $content = Yii::t('mc', 'No backup in progress');
                $start = true;
                break;
            case 'done':
                $content = Yii::t('mc', 'Backup completed.').' '.($backup[0]['time'] ? Yii::t('mc', '(Last backup: {date})', array('{date}'=>@date('Y-m-d H:i', $backup[0]['time']))) : '');
                $start = true;
                if (strpos($backup[0]['message'], 'second') !== false)
                    $content .= "\n\n".$backup[0]['message'];
                break;
            case 'running':
                $content = Yii::t('mc', 'Backup in progress...');
                break;
            case 'error':
            default:
                if (!$error)
                    $error = $backup[0]['message'];
                $content = $error ? $error : Yii::t('mc', 'Error during backup, please check the daemon log');
                $cls = 'flash-error';
                $start = true;
                break;
            }
            echo '<div class="'.$cls.'" style="white-space: pre">'.CHtml::encode($content).'</div>';
   
            if (@$backup[0]['ftp'])
            {
                if (@Yii::app()->params['ftp_client_disabled'] !== true)
                {
                    echo Yii::t('mc', 'Any backups that reside in your server directory can be accessed using the {link}.',
                        array('{link}'=>CHtml::link(Yii::t('mc', 'Multicraft FTP client'), array('ftpClient/login', 'id'=>$server->id))));
                    echo '<br/>';
                    echo '<br/>';
                }
                else
                {
                    echo Yii::t('mc', 'Any backups that reside in your server directory can be accessed on the following FTP server:').'<br/>';
                    $ftp = explode(':', $backup[0]['ftp']);
                    $port = @array_pop($ftp);
                    $ip = ''.@implode(':', $ftp);
                    $dmn = Daemon::model()->findByPk($server->daemon_id);
                    if ($dmn && isset($dmn->ftp_ip) && isset($dmn->ftp_port))
                    {
                        $ip = $dmn->ftp_ip;
                        $port = $dmn->ftp_port;
                    }
                    $ip = @str_replace(array('[', ']'), '', $ip);
                    $attr = array();
                    $attr[] = array('label'=>Yii::t('mc', 'Host'), 'value'=>$ip);
                    $attr[] = array('label'=>Yii::t('mc', 'Port'), 'value'=>$port);
                    $attr[] = array('label'=>Yii::t('mc', 'User'), 'value'=>Yii::app()->user->name.'.'.$server->id);
                    $attr[] = array('label'=>Yii::t('mc', 'Password'), 'value'=>Yii::t('mc', 'Your Multicraft login password'));
                    $this->widget('zii.widgets.CDetailView', array(
                        'data'=>array(),
                        'attributes'=>$attr,
                    ));
                }
            }

            $ret['backup'] = ob_get_clean();
        }
        if ($all || in_array('movestatus', $type))
        {
            $error = false;
            ob_start();
            try
            {
                $sql = 'select `src_dmn`, `dst_dmn`, `status`, `message` from `move_status` where `server_id`=?';
                $cmd = Yii::app()->bridgeDb->createCommand($sql);
                $cmd->bindValue(1, $server->id);
                $row = $cmd->queryRow(false);
            }
            catch (Exception $e)
            {
                $row = array(0, 0, 'error', 'Failed to load status from database.');
            }
            if($row && Yii::app()->user->isStaff()):
                $flash = 'success';
                if ($row[2] == 'error')
                    $flash = 'error';

            $msg = array(
                'started'=>Yii::t('mc', 'Server move started'),
                'packing'=>Yii::t('mc', 'Packing server files on source daemon'),
                'uploading'=>Yii::t('mc', 'Uploading server files to new daemon'),
                'notifying'=>Yii::t('mc', 'Notifying new daemon of completed transfer'),
                'transferred'=>Yii::t('mc', 'Transfer complete, starting unpack'),
                'unpacking'=>Yii::t('mc', 'Unpacking server files on destination daemon'),
                'unsuspending'=>Yii::t('mc', 'Unsuspending server'),
                'done'=>Yii::t('mc', 'Servermove completed.'),
                'error'=>Yii::t('mc', 'Server move failed, please check the server console and multicraft.log. Last error:'),
            );

            $msg = @$msg[$row[2]];
            if (!$msg)
                $msg = $row[2];

            ?>
            <div class="flash-<?php echo $flash ?>">
                <span style="float: right">
                    <?php echo CHtml::link(Yii::t('mc', 'Dismiss'), '#', array(
                        'submit'=>array('dismiss', 'id'=>$server->id),
                        'csrf'=>true,
                    )) ?>
                </span>
                <?php echo Yii::t('mc', 'Server move status from daemon {a} to daemon {b}:', array('{a}'=>$row[0], '{b}'=>$row[1])) ?>
                <br/>
                <?php echo $msg ?><br/>
                <?php echo $row[3] ?>
            </div>
            <?php endif;
            $ret['movestatus'] = ob_get_clean();
        }
        return $ret;
    }

    public function actionChat($id)
    {
        Yii::app()->user->can($id, 'chat', true);
        $model = $this->loadModel($id);
        $all = array('players', 'chat', 'status');
        if (isset($_POST['ajax']))
        {
            switch($_POST['ajax'])
            {
            case 'refresh':
                header('Content-type: application/json');
                echo CJSON::encode($this->ajaxRefresh($model, $all));
                break;
            case 'clearChat':
                if (!Yii::app()->user->can($model->id, 'clear_chat'))
                    echo Yii::t('mc', 'Permission denied');
                else if (!McBridge::get()->serverCmd($model->id, 'clear chat'))
                    echo Yii::t('mc', 'Failed to clear chat: ').McBridge::get()->lastError();
                break;
            case 'chat':
                $message = $_POST['message'];
                if (!Yii::app()->user->can($model->id, 'chat'))
                    echo Yii::t('mc', 'Permission denied');
                else if (Yii::app()->params['block_chat_characters'] && preg_match("/[\n\\\\\\/'\";&|$]/", $message))
                    echo Yii::t('mc', 'Please don\'t use special characters.');
                else if (strlen($message) > 512)
                    echo Yii::t('mc', 'Message too long.');
                else if (strlen($message))
                {
                    $from = Yii::app()->user->isGuest ? Yii::t('mc', 'Guest') : Yii::app()->user->name;
                    if (Yii::app()->params['ip_auth'] && McBridge::get()->serverCmd($model->id, 'get players', $players))
                    {
                        foreach ($players as $player)
                            if ((User::getRoleLevel($model->getIpAuthRole()) >= User::getRoleLevel('guest')) && ($player['ip'] == $this->ip))
                            {
                                $from .= ' ('.$player['name'].')';
                                break;
                            }
                    }
                    if (!McBridge::get()->serverCmd($model->id, 'mc:say <'.$from.'> '.$message, $tmp))
                        echo Yii::t('mc', 'Error sending chat: ').McBridge::get()->lastError();
                }
                break;
            case 'kick':
                if (Yii::app()->user->can($model->id, 'kick'))
                {
                    $player = @$_POST['player'];
                    if ($player)
                        McBridge::get()->serverCmd($model->id, 'mc:kick '.preg_replace("/\n/", '', $player));
                }
                break;
            }
            Yii::app()->end();
        }
        $this->render('chat',array(
            'model'=>$model,
            'getChat'=>Yii::app()->user->can($model->id, 'get_chat'),
            'chat'=>Yii::app()->user->can($model->id, 'chat'),
            'getPlayers'=>Yii::app()->user->can($model->id, 'get_players'),
            'give'=>Yii::app()->user->can($model->id, 'give'),
            'tp'=>Yii::app()->user->can($model->id, 'tp'),
            'viewLog'=>Yii::app()->user->can($model->id, 'get_log'),
            'command'=>Yii::app()->user->can($model->id, 'command'),
            'data'=>$this->ajaxRefresh($model, $all),
        ));
    }

    public function actionLog($id)
    {
        Yii::app()->user->can($id, 'get_log', true);
        $model = $this->loadModel($id);
        $all = array('log', 'status', 'buttons');
        if (isset($_POST['ajax']))
        {
            switch($_POST['ajax'])
            {
            case 'refresh':
                header('Content-type: application/json');
                echo CJSON::encode($this->ajaxRefresh($model, $all));
                break;
            case 'clearLog':
                if (!Yii::app()->user->can($model->id, 'clear_log'))
                    echo Yii::t('mc', 'Permission denied');
                else if (!McBridge::get()->serverCmd($model->id, 'clear log'))
                    echo Yii::t('mc', 'Failed to clear log: ').McBridge::get()->lastError();
                break;
            case 'command':
                $cmd = $_POST['command'];
                if (!Yii::app()->user->can($model->id, 'command'))
                    echo Yii::t('mc', 'Permission denied');
                else if (preg_match("/[\n\\\\]/", $cmd))
                    echo Yii::t('mc', 'Please don\'t use special characters.');
                else if (strlen($cmd) > 512)
                    echo Yii::t('mc', 'Message too long.');
                else if (strlen($cmd))
                {
                    if (!McBridge::get()->serverCmd($model->id, (Yii::app()->user->isStaff() ? 'run_s:' : 'run:').$cmd))
                        echo Yii::t('mc', 'Error sending command: ').McBridge::get()->lastError();
                    if (Yii::app()->params['log_console_commands'])
                        McBridge::get()->serverCmd($model->id, 'print:'.Yii::app()->user->name.' ran command: '.$cmd);
                }
                break;
            }
            Yii::app()->end();
        }
        $this->render('log',array(
            'model'=>$model,
            'data'=>$this->ajaxRefresh($model, $all),
            'command'=>Yii::app()->user->can($model->id, 'command'),
        ));
        
    }

    public function actionIndex($my = false)
    {
        if (!Yii::app()->user->showList)
            $my = true;
        else if (Yii::app()->user->isGuest)
            $my = false;
        $criteria = new CDbCriteria;
        if (isset($_POST['ajax']))
        {
            switch($_POST['ajax'])
            {
            case 'get_status':
                $id = (int)@$_POST['server'];
                $sv = Server::model()->findByPk($id);
                $data = 0;
                $susp = 0;
                $maxpl = 0;
                $chat = Yii::app()->user->can($id, 'chat') ? 1 : 0;
                if ($sv)
                {
                    $data = $sv->getOnlinePlayers();
                    $susp = $sv->suspended;
                    $maxpl = $sv->players;
                }
                header('Content-type: application/json');
                echo CJSON::encode(array('id'=>(int)$id, 'sp'=>$susp, 'pl'=>$data, 'max'=>$maxpl, 'chat'=>$chat));
                break;
            }
            Yii::app()->end();
        }
        if (!Yii::app()->user->isStaff() && !in_array(Yii::app()->user->globalRole, array('owner', 'coowner')))
        {
            $ids = array();
            if (!$my)
            {
            //get default visible
            $sql = 'select `id` from `server` where `default_level`>=?';
            $cmd = Yii::app()->bridgeDb->createCommand($sql);
            $cmd->bindValue(1, (int)User::getRoleLevel('guest'));
            $ids = $cmd->queryColumn();

            //remove never visible
            $sql = 'select `server_id` from `server_config` where `visible`!=1';
            $cmd = Yii::app()->db->createCommand($sql);
            $ids = array_diff($ids, $cmd->queryColumn());

            //add always visible
            /*$sql = 'select `server_id` from `server_config` where `visible`=';
            $cmd = Yii::app()->db->createCommand($sql);
            $ids = array_merge($ids, $cmd->queryColumn());*/
            }

            if (!Yii::app()->user->isGuest)
            {
                //add user visible
                $cmd = Yii::app()->db->createCommand($this->ownServerSql);
                $cmd->bindValue(1, (int)Yii::app()->user->id);
                $ids = array_merge($ids, $cmd->queryColumn());
            }
            if ($my && count($ids) == 1)
                $this->redirect(array('server/view', 'id'=>$ids[0]));
            if (count($ids))
                $criteria->addInCondition('`id`', array_values($ids));
            else
                $criteria->compare('`id`', 0);
        }

        if ($spp = Setting::model()->findByPk('serversPerPage'))
            $spp = max(1, (int)$spp->value);

        $this->render('index',array(
            'dataProvider'=>new CActiveDataProvider('Server', array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'attributes'=>array(
                        'name', 
                    ),
                    'defaultOrder'=>'`name` asc',
                ),
                'pagination'=>array('pageSize'=>$spp),
            )),
            'my'=>$my,
        ));
    }

    public function actionAdmin()
    {
        $model = new Server('search');
        $model->unsetAttributes();
        if (isset($_GET['Server']))
            $model->attributes = $_GET['Server'];

        $this->render('admin', array(
            'model'=>$model,
        ));
    }

    public function actionBackup($id)
    {
        if (@Yii::app()->params['backup_world_disable'] && !@Yii::app()->params['backup_full'])
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        Yii::app()->user->can($id, 'get_backup', true);
        $model = $this->loadModel($id);
        if (isset($_POST['ajax']))
        {
            switch($_POST['ajax'])
            {
            case 'refresh':
                header('Content-type: application/json');
                echo CJSON::encode($this->ajaxRefresh($model, 'backup'));
                break;
            case 'start':
            case 'start_full':
                if (!Yii::app()->user->can($model->id, 'start_backup'))
                    die(Yii::t('mc', 'Access denied!'));
                if ($_POST['ajax'] == 'start' && @Yii::app()->params['backup_world_disable'])
                    break;
                if ($_POST['ajax'] == 'start_full' && !@Yii::app()->params['backup_full'])
                    break;
                if (!McBridge::get()->serverCmd($model->id, (($_POST['ajax'] == 'start') ? '' : 'full').'backup start'))
                    echo McBridge::get()->lastError();
                break;
            }
            Yii::app()->end();
        }
                
        
        $this->render('backup',array(
            'model'=>$model,
            'data'=>$this->ajaxRefresh($model, 'backup'),
            'restore'=>Yii::app()->user->can($id, 'restore_backup'),
        ));
    }

    public function actionFtp($id)
    {
        Yii::app()->user->can($id, 'manage_users', true);
        $model = $this->loadModel($id);

        $dmnInfo = array('ip'=>'', 'port'=>'');
        if (!Yii::app()->user->model || !Yii::app()->user->model->getServerFtpAccess($model->id))
            $dmnInfo['error'] = Yii::t('mc', 'You don\'t have an FTP account for this server.');
        else
        {
            $dmn = Daemon::model()->findByPk($model->daemon_id);
            if (!$dmn)
                $dmnInfo['error'] = Yii::t('mc', 'No daemon found for this server.');
            else if (isset($dmn->ftp_ip) && isset($dmn->ftp_port))
                $dmnInfo = array('ip'=>$dmn->ftp_ip, 'port'=>$dmn->ftp_port);
            else
                $dmnInfo['error'] = Yii::t('mc', 'Daemon database not up to date, please run the Multicraft installer.');
        }

        $this->render('ftp',array(
            'model'=>$model,
            'dmnInfo'=>$dmnInfo,
        ));
    }

    public function checkFile($file)
    {
        if (!preg_match('/^[^\/\\\?%\*"\'<>\0]+\.zip/i', $file))
            return false;
        return true;
    }

    public function actionRestore($id)
    {
        if (@Yii::app()->params['backup_world_disable'])
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        Yii::app()->user->can($id, 'restore_backup', true);
        $model = $this->loadModel($id);

        if (@$_POST['restore'] === 'true')
        {
            $file = @$_POST['file'];
            if (!$this->checkFile($file))
                Yii::app()->user->setFlash('server', Yii::t('mc', 'Filename contains invalid characters'));
            else if (!McBridge::get()->serverCmd($model->id, 'backup restore '.$file))
            {
                $err = McBridge::get()->lastError();
                if ($err == 'inprogress')
                    Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because another unpack operation is currently in progress'));
                else if ($err == 'invalid')
                    Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because it contains invalid files (absolute paths or paths outside of the unpack directory). See the log for details.'));
                else if ($err == 'forbidden')
                    Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because it contains restricted file types. See the log for details.'));
                else
                    Yii::app()->user->setFlash('server', CHtml::encode($err));
            }
            $this->redirect(array('restore', 'id'=>$model->id));
            Yii::app()->end();
        }

        $list = array();
        $error = '';
        $data = array();
        if (!McBridge::get()->serverCmd($model->id, 'backup list', $data))
            Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
        else
        {
            $files = array();
            foreach ($data as $d)
                $files[$d['file']] = $d['time'];
            ksort($files);
            foreach ($files as $f=>$t)
                $list[] = array('id'=>$f, 'time'=>@date("d.m.Y H:i", $t));            
        }

    
        $this->render('restore',array(
            'dataProvider'=> new CArrayDataProvider($list, array(
                'pagination'=>array('pageSize'=>10),
            )),
            'model'=>$model,
        ));
    }

    public function actionRestoreFull($id)
    {
        if (!@Yii::app()->params['backup_full'])
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        Yii::app()->user->can($id, 'restore_backup', true);
        $model = $this->loadModel($id);

        if (@$_POST['do'] === 'true')
        {
            $file = @$_POST['file'];
            if (!$this->checkFile($file))
                Yii::app()->user->setFlash('server', Yii::t('mc', 'Filename contains invalid characters'));
            else if (@$_POST['action'] == 'restore')
            {
                if (!McBridge::get()->serverCmd($model->id, 'fullbackup restore '.$file))
                {
                    $err = McBridge::get()->lastError();
                    if ($err == 'inprogress')
                        Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because another unpack operation is currently in progress'));
                    else if ($err == 'invalid')
                        Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because it contains invalid files (absolute paths or paths outside of the unpack directory). See the log for details.'));
                    else if ($err == 'forbidden')
                        Yii::app()->user->setFlash('server', Yii::t('mc', 'Failed to unpack archive because it contains restricted file types. See the log for details.'));
                    else
                        Yii::app()->user->setFlash('server', CHtml::encode($err));
                }
            }
            else if (@$_POST['action'] == 'rename')
            {
                $target = @$_POST['target'];
                if (substr($target, -strlen('.zip')) != '.zip')
                    $target .= '.zip';
                if (!$this->checkFile($target))
                    Yii::app()->user->setFlash('server', Yii::t('mc', 'Target filename contains invalid characters'));
                else if (!McBridge::get()->serverCmd($model->id, 'fullbackup rename '.$file.'/'.$target))
                    Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
            }
            else if (@$_POST['action'] == 'move')
            {
                if (!McBridge::get()->serverCmd($model->id, 'fullbackup move '.$file))
                    Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
            }
            else if (@$_POST['action'] == 'delete')
            {
                if (!McBridge::get()->serverCmd($model->id, 'fullbackup delete '.$file))
                    Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
            }
            $this->redirect(array('restoreFull', 'id'=>$model->id));
            Yii::app()->end();
        }

        $list = array();
        $error = '';
        $data = array();
        $size = false;
        if (!McBridge::get()->serverCmd($model->id, 'fullbackup list', $data))
            Yii::app()->user->setFlash('server', CHtml::encode(McBridge::get()->lastError()));
        else
        {
            $files = array();
            foreach ($data as $d)
                $files[$d['file']] = array($d['time'], @$d['size']);
            ksort($files);
            foreach ($files as $f=>$v)
                $list[] = array('id'=>$f, 'time'=>@date("d.m.Y H:i", $v[0]), 'size'=>$v[1]);
            $size = isset($data[0]['size']);
        }

    
        $this->render('restoreFull',array(
            'dataProvider'=> new CArrayDataProvider($list, array(
                'pagination'=>array('pageSize'=>10),
            )),
            'model'=>$model,
            'size'=>$size,
        ));
    }

    public function actionMysqlDb($id)
    {
        Yii::app()->user->can($id, 'manage_mysql', true);
        $model = $this->loadModel($id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!strlen($model->mysqlHost)
            || !((Yii::app()->params['user_mysql'] && $settings->user_mysql) || Yii::app()->user->isStaff()))
            Yii::app()->user->deny();
        $cmd = @$_POST['cmd'];
        if ($cmd == 'create')
        {
            if (!$model->createDatabase())
            {
                Yii::app()->user->setFlash('server_error',
                    Yii::t('mc', 'Failed to create MySQL database "{db}"!', array('{db}'=>
                        CHtml::encode($model->mysqlPrefix.$model->id)))
                    .' '.Yii::t('mc', 'Additional details have been logged for your administrator'));
            }
            $this->redirect(array('mysqlDb', 'id'=>$model->id));
        }
        else if ($cmd == 'passwd')
        {
            if (!$model->changeDatabasePw())
            {
                Yii::app()->user->setFlash('server_error',
                    Yii::t('mc', 'Failed to change MySQL password for "{db}"!', array('{db}'=>
                        CHtml::encode($model->mysqlPrefix.$model->id)))
                    .' '.Yii::t('mc', 'Additional details have been logged for your administrator'));
            }
            $this->redirect(array('mysqlDb', 'id'=>$model->id));
        }
        else if ($cmd == 'delete')
        {
            if (!$model->deleteDatabase())
            {
                Yii::app()->user->setFlash('server_error',
                    Yii::t('mc', 'Failed to delete MySQL database "{db}"!', array('{db}'=>
                        CHtml::encode($model->mysqlPrefix.$model->id)))
                    .' '.Yii::t('mc', 'Additional details have been logged for your administrator'));
            }
            $this->redirect(array('mysqlDb', 'id'=>$model->id));
        }
        $this->render('mysqlDb',array(
            'model'=>$model,
            'info'=>$model->dbInfo,
        ));
    }

    public function loadModel($id)
    {
        $model=Server::model()->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,Yii::t('mc', 'The requested page does not exist.'));
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='server-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSetup($id, $tplSuggest = '')
    {
        if (@Yii::app()->params['templates_disabled'] === true)
            throw new CHttpException(404,Yii::t('mc', 'The requested page does not exist.'));
        $id = (int)$id;
        Yii::app()->user->can($id, 'manage_templates', true);
        $model = $this->loadModel($id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!Yii::app()->user->isStaff() && (!$settings || !$settings->user_templates))
            Yii::app()->user->deny();

        $ret = McBridge::get()->cmd($model->daemon_id, 'listtemplates');

        $templates = array();
        $status = '';
        if (!$ret['success'])
            $status = 'error';
        if (!is_array($ret['data']))
            $ret['data'] = array();
        // Template name translations:
        // Yii::t('mc', 'Clean Mod Directories and Plugins')
        foreach ($ret['data'] as $tpl)
            $templates[$tpl['template']] = Yii::t('mc', $tpl['name']);
        asort($templates);

        if ($tplSuggest && !@$_POST['template'])
        {
            $tplArr = @explode('|', $tplSuggest);
            $opts = (is_array($tplArr) && count($tplArr) > 1) ? @explode(',', $tplArr[1]) : array();
            $_POST['template'] = @$tplArr[0];
            $_POST['always'] = @in_array('always', $opts) ? '1' : '0';
            $_POST['delete'] = @in_array('delete', $opts) ? '1' : '0';
        }

        if(@$_POST['setup'] === 'true')
        {
            $doDelete = false;
            if (@$_POST['delete_files'] === '1' && @$_POST['confirm_password'] && Yii::app()->user->verifyPassword(@$_POST['confirm_password']))
                $doDelete = true;
            else if (@$_POST['delete_files'] === '1')
                $model->addError('template', Yii::t('mc', 'Password does not match'));

            if (!$model->hasErrors())
            {
                $model->template = ''.@$_POST['template'];
                $setup = array('install');
                if (@$_POST['always'])
                    $setup[] = 'always';
                if ($doDelete === true)
                    $setup[] = 'delete';
                $model->setup = ''.implode(',', $setup);
                if ($model->save())
                    $this->redirect(array('setup', 'id'=>$model->id));
            }
        }
        else if(@$_POST['cancel_setup'] === 'true')
        {
            $model->template = '';
            $model->setup = '';
            if ($model->save())
                $this->redirect(array('setup', 'id'=>$model->id));
        }

        $this->render('setup',array(
            'model'=>$model,
            'status'=>$status,
            'templates'=>$templates,
        ));
    }

    public function actionParams($id)
    {
        Yii::app()->user->can($id, 'manage_params', true);
        $model = $this->loadModel($id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!Yii::app()->user->isStaff() && (!$settings || !$settings->user_params))
            Yii::app()->user->deny();

        $params = explode(',', $model->params);
        if (count($params))
        {
            if (!in_array($params[0], array('jar:', 'jar:'.$model->jarfile)))
                $params = array(); // Parameter selection was for a different executable, clear value
            else
                unset($params[0]); // Remove executable name
        }

        if(Yii::app()->request->isPostRequest)
        {
            if (!isset($_POST['param']))
                die(Yii::t('mc', 'Missing argument'));

            $param = $_POST['param'];
            $checked = @$_POST['checked'];
            $in = in_array($param, $params);

            // Remove or add param in params array depending on checkbox state
            if (!$checked && $in)
                unset($params[array_search($param, $params)]);
            else if ($checked && !$in)
                $params[] = $param;

            // Filter out empty values and sort params
            $params = array_filter($params, 'strlen');
            asort($params);

            // Write back parameters with current executable name
            $model->params = 'jar:'.$model->jarfile.','.implode(',', $params);
            if (!$model->save())
                die(Yii::t('mc', 'Failed to save parameter list'));
            Yii::app()->end();
        }

        $list = array();
        $error = '';

        // Retrieve list of available parameters with their info string
        $res = McBridge::get()->cmd($model->daemon_id, 'server '.$model->id.':get_params');
        if (!$res['success'] || !isset($res['data'][0]))
            $error = CHtml::encode($res['error']);
        if (!is_array(@$res['data']))
            $res['data'] = array();
        foreach ($res['data'] as $data)
        {
            $list[] = array(
                'id'=>$data['id'],
                'info'=>$data['info'],
                'param'=>$data['param'],
                'checked'=>in_array($data['id'], $params)
            );
        }

        $this->render('params', array(
            'dataProvider'=> new CArrayDataProvider($list, array(
                'sort'=>array(
                    'attributes'=>array(
                        'param', 'info',
                    ),
                ),
                'pagination'=>false,
            )),
            'model'=>$model,
            'error'=>$error,
            'params'=>$params,
        ));
    }

    public function actionPorts($id)
    {
        if (!Yii::app()->params['additional_ports'])
            Yii::app()->user->deny();
        Yii::app()->user->can($id, 'edit', true);
        $model = $this->loadModel($id);
        $settings = ServerConfig::model()->findByPk($model->id);
        if (!Yii::app()->user->isStaff() && (!$settings || !isset($settings->user_add_ports) || !$settings->user_add_ports))
            Yii::app()->user->deny();

        $cmd = Yii::app()->bridgeDb->createCommand('select `port` as `id` from `server_port` where `server_id`=?');
        $ports = $cmd->bindValue(1, $model->id);
        $ports = $cmd->queryAll();

        $action = @$_POST['action'];
        if ($action == 'admin_add' && Yii::app()->user->isStaff() && (int)@$_POST['admin_port'])
        {
            if (!$model->addServerPort((int)$_POST['admin_port']))
                Yii::app()->user->setFlash('server_error', $model->getError('port'));
            $this->redirect(array('ports','id'=>$id));
        }
        else if ($action == 'add')
        {
            if (count($ports) >= Yii::app()->params['additional_ports'])
            {
                Yii::log('Maximum port count reached for server '.$model->id, 'warning');
                Yii::app()->user->setFlash('server_error',
                    Yii::t('mc', 'Failed to allocate new port.')
                    .' '.Yii::t('mc', 'Maximum port count reached.'));
                $this->redirect(array('ports','id'=>$id));
            }
            if (!$model->addServerPort())
                Yii::app()->user->setFlash('server_error', $model->getError('port'));
            $this->redirect(array('ports','id'=>$id));
        }
        else if ($action == 'remove')
        {
            $model->removeServerPort((int)$_POST['port']);
            $this->redirect(array('ports','id'=>$id));
        }

        $this->render('ports', array(
            'model'=>$model,
            'ports'=>$ports,
        ));
    }
}

class DummyDb
{
    public function createCommand()
    {
        return $this;
    }

    public function bindValue() {}

    public function quoteColumnName() {}

    public function quoteValue() {}

    public function execute() {}
}

