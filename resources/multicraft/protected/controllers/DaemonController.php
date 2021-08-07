<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class DaemonController extends Controller
{
    public $layout = '//layouts/column2';


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
                'expression'=>'$user->isSuperuser()',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $settings= array();
        $settings['saveInterval'] =
            array('label'=>Yii::t('admin', 'Autosave Interval (0 to disable)'), 'unit'=>'s', 'factor'=>1000, 'default'=>600);
        $settings['maxChatLines'] =
            array('label'=>Yii::t('admin', 'Number of lines to store in chat window'), 'unit'=>'', 'default'=>120);
        $settings['maxLogLines'] =
            array('label'=>Yii::t('admin', 'Number of lines to store in log/console window'), 'unit'=>'', 'default'=>120);
        if (!@Yii::app()->params['backup_world_disable'])
        $settings['keepBackupCount'] =
            array('label'=>Yii::t('admin', 'Number of backups to keep'), 'unit'=>'', 'default'=>3);
        if (@Yii::app()->params['backup_full'])
        $settings['keepFullBackupCount'] =
            array('label'=>Yii::t('admin', 'Number of full backups to keep'), 'unit'=>'', 'default'=>3);
        $settings['serversPerPage'] =
            array('label'=>Yii::t('admin', 'Number of servers per page'), 'unit'=>'', 'default'=>10);
        $settings['defaultServerName'] =
            array('label'=>Yii::t('admin', 'Default server name'), 'unit'=>'', 'default'=>'Minecraft Server');
        $settings['defaultServerPlayers'] =
            array('label'=>Yii::t('admin', 'Default number of player slots'), 'unit'=>'', 'default'=>8);
        $settings['defaultServerMemory'] =
            array('label'=>Yii::t('admin', 'Default amount of memory'), 'unit'=>Yii::t('admin', 'MB'), 'default'=>1024);
        $settings['defaultServerIp'] =
            array('label'=>Yii::t('admin', 'Default server IP'), 'unit'=>array(0=>Yii::t('admin', 'All interfaces (0.0.0.0)'), 1=>Yii::t('admin', 'Daemon IP'), 2=>Yii::t('admin', 'Daemon FTP Server IP')), 'default'=>0);
        $settings['defaultServerPort'] =
            array('label'=>Yii::t('admin', 'Base server port to use on new IPs'), 'unit'=>'', 'default'=>25565);
        $settings['minecraftEula'] =
            array('label'=>Yii::t('admin', 'Minecraft EULA'), 'unit'=>array('manual'=>Yii::t('admin', 'Manual'), 'button'=>Yii::t('admin', 'Show "Accept EULA" button'), 'auto'=>Yii::t('admin', 'Automatically accept')), 'default'=>'button');
        $settings['defaultServerStartMemory'] =
            array('label'=>Yii::t('admin', 'Default amount of startup memory'), 'unit'=>Yii::t('admin', 'MB'), 'default'=>0, 'adv'=>true);
        $settings['updateChecks'] =
            array('label'=>Yii::t('admin', 'Check for Multicraft updates'), 'unit'=>'bool', 'default'=>1, 'adv'=>true);
        $settings['anonStats'] =
            array('label'=>Yii::t('admin', 'Anonymous usage statistics'), 'unit'=>'bool', 'default'=>1, 'adv'=>true);
        $settings['pingInterval'] =
            array('label'=>Yii::t('admin', 'Crash Check Interval (0 to disable)'), 'unit'=>'s', 'factor'=>1000, 'default'=>30, 'adv'=>true);
        $settings['pingTimeout'] =
            array('label'=>Yii::t('admin', 'Response Timeout (0 to disable)'), 'unit'=>'s', 'factor'=>1000, 'default'=>0, 'adv'=>true);
        $settings['allowTimeouts'] =
            array('label'=>Yii::t('admin', 'Number of Ping Timeouts to Allow'), 'unit'=>'', 'default'=>1, 'adv'=>true);
        $settings['restartDelay'] =
            array('label'=>Yii::t('admin', 'Server Restart Delay'), 'unit'=>'s', 'factor'=>1000, 'default'=>3, 'adv'=>true);
        $settings['crashRestartDelay'] =
            array('label'=>Yii::t('admin', 'Crashed Server Restart Delay (0 to disable)'), 'unit'=>'s', 'factor'=>1000, 'default'=>5, 'adv'=>true);
        $settings['userSaveDelay'] =
            array('label'=>Yii::t('admin', 'Minimum time between two world saves'), 'unit'=>'s', 'factor'=>1000, 'default'=>120, 'adv'=>true);
        $settings['userBackupDelay'] =
            array('label'=>Yii::t('admin', 'Minimum time between two world backups'), 'unit'=>'s', 'factor'=>1000, 'default'=>300, 'adv'=>true);
        $settings['resourceCheckInterval'] =
            array('label'=>Yii::t('admin', 'Minimum time between two resource checks (0 to disable)'), 'unit'=>'s', 'factor'=>1000, 'default'=>1, 'adv'=>true);
        $settings['pongMode'] =
            array('label'=>Yii::t('admin', 'Assume servers are still running on'), 'unit'=>array(0=>Yii::t('admin', 'Known console output'), 1=>Yii::t('admin', '"List" command output'), 2=>Yii::t('admin', 'Any console output')), 'default'=>0, 'adv'=>true);
        $settings['rateLimit'] =
            array('label'=>Yii::t('admin', 'Limit number of console lines per second to'), 'unit'=>'', 'default'=>30, 'adv'=>true);
        $settings['pluginScanDelay'] =
            array('label'=>Yii::t('admin', 'Plugin repository refresh interval'), 'unit'=>'s', 'factor'=>1000, 'default'=>5, 'adv'=>true);
        $settings['savePlayerInfo'] =
            array('label'=>Yii::t('admin', 'Save player information (ip, lastseen, etc.)'), 'unit'=>array(2=>Yii::t('admin', 'Always Save'), 1=>Yii::t('admin', 'Update Existing'), 0=>Yii::t('admin', 'Never Save')), 'default'=>2, 'adv'=>true);
        $settings['additionalPorts'] =
            array('label'=>Yii::t('admin', 'Number of additional ports to reserve for each server'), 'unit'=>'', 'default'=>0, 'adv'=>true, 'hint'=>Yii::t('admin', 'When allocating new ports for servers this number of ports will be skipped. Also creates additional bindings for Docker containers for these ports.'));
        
        if (isset($_POST['submit']) && $_POST['submit'] === 'true')
        {
            foreach (array_keys($settings) as $s)
            {
                $value = @$_POST['Setting'][$s];
                $model = Setting::model()->findByPk($s);
                if (!$model)
                {
                    $model = new Setting();
                    $model->key = $s;
                }
                $f = isset($settings[$s]['factor']) ? $settings[$s]['factor'] : 0;
                $value = $f ? intval($value) * $f : $value;
                if (!$value && $value !== "0")
                    $value = '';
                
                if ($value != $model->value)
                    Yii::log(array('update', $model, '"'.$value.'"'));
                $model->value = $value;
                $model->save();
            }
            Yii::log('Updated global settings');
            $this->redirect(array('index'));
        }
    
        foreach (array_keys($settings) as $s)
        {
            $f = isset($settings[$s]['factor']) ? $settings[$s]['factor'] : 0;
            $model = Setting::model()->findByPk($s);
            $val = '';
            if (!$model)
                $val = $settings[$s]['default'];
            else
                $val = $f ? intval($model->value) / $f : $model->value;
            $settings[$s]['value'] = $val;
        }


        $this->render('index',array(
            'settings'=>$settings,
        ));
    }

    public function ajaxAction($cmd, $dmn)
    {
        $dmn = (int)$dmn;
        if ($dmn)
        {
            $ret = McBridge::get()->cmd($dmn, $cmd);
            if (!$ret['success'])
                echo  CHtml::encode(Yii::t('admin', 'Daemon').' '.$dmn.': '.$ret['error']."\n");
        }
        else
        {
            $ret = McBridge::get()->globalCmd($cmd);
            foreach ($ret as $id=>$r)
                if (!$r['success'])
                    echo  CHtml::encode(Yii::t('admin', 'Daemon').' '.$id.': '.$r['error']."\n");
        }
    }

    public function actionAjaxGetDaemonStatus($id)
    {
        $id = (int)$id;
        $ds = Daemon::model()->findByPk($id);
        if (!$ds)
            throw new CHttpException(404, 'Daemon not found');
        $ret = McBridge::get()->cmd($ds->id, 'version');
        if (!$ret['success'])
        {
            $content = $ret['error'];
            $cls = 'error';
        }
        else
        {
            $vs = @$ret['data'][0]['version'];
            $rem = @$ret['data'][0]['remote'];
            if ($vs == $rem)
                $content = Yii::t('admin', 'Up to date').' ('.$vs.')';
            else
                $content = Yii::t('admin', 'Version: {version} (latest: {remote})', array('{version}'=>$vs, '{remote}'=>$rem));
            $info = @$ret['data'][0]['info'];
            if ($info)
                $content .= '<br/>'.$info;
            $cls = 'success';
        }
        header('Content-type: application/json');
        echo CJSON::encode(array('content'=>$content, 'class'=>$cls));
    }

    public function actionAjaxGetUpdateStatus($id)
    {
        $id = (int)$id;
        $ds = Daemon::model()->findByPk($id);
        if (!$ds)
            throw new CHttpException(404, 'Daemon not found');
        $ret = McBridge::get()->cmd($ds->id, 'updatejar status :1');
        if (!$ret['success'])
        {
            $content = Yii::t('admin', 'Error, please check daemon connection');
            $cls = 'error';
        }
        else
        {
            $data = $ret['data'];
            if (!is_array($data) || !count($data))
                $data = array('time'=>time());
            $content = '';
            $fails = 0;
            foreach ($data as $d)
            {
                if ($content)
                    $content .= '<br/>';
                $time = @$d['time'] ? '['.@date('m/d H:i', $d['time']).'] ' : '';
                if (isset($d['target']))
                    $content .= '<b>'.$d['target'].'</b>: ';
                switch (@$d['status'])
                {
                case 'done':
                    $content .= Yii::t('admin', 'Update successful');
                    break;
                case 'uptodate':
                    $content .= Yii::t('admin', 'Up to date');
                    break;
                case 'ready':
                    $content .= Yii::t('admin', 'Ready for installation');
                    break;
                case 'running':
                    $content .= Yii::t('admin', 'Downloading {percent}', array('{percent}'=>($d['percent'] ?
                            ' '.(int)((float)$d['percent'] * 100).'%' : '')));
                    break;
                default:
                    if (@$d['message'])
                    {
                        $fails++;
                        $content .= htmlspecialchars($d['message']);
                    }
                    else
                        $content .= Yii::t('admin', 'No update in progress');
                }
            }
            if ($fails)
                $cls = 'notice';
            else
                $cls = 'success';
        }
        $ret = McBridge::get()->cmd($ds->id, 'updatejar list :');

        $jars = array();
        if (@$ret['success'])
        {
            foreach ($ret['data'] as $jar)
                $jars[$jar['jar']] = $jar['name'];
        }
        natcasesort($jars);
        header('Content-type: application/json');
        echo CJSON::encode(array('content'=>$content, 'class'=>$cls, 'jars'=>$jars));
    }

    public function actionUpdateMC()
    {
        if (isset($_POST['ajax']))
        {
            switch($_POST['ajax'])
            {
            case 'start':
            case 'update':
                if (!in_array($_POST['file'], array('both', 'jar', 'conf')))
                    die(Yii::t('admin', 'Please choose a file type to download.'));
                if ($_POST['file'] == 'both')
                    $_POST['file'] = '';
                $cmd = 'updatejar '.$_POST['ajax'].' :'.$_POST['file'].':'.$_POST['target'];
                $this->ajaxAction($cmd, @$_POST['daemon']);
                Yii::log('Starting download of JAR file '.$_POST['file']);
                break;
            case 'install':
                $cmd = 'updatejar install :1';
                $this->ajaxAction($cmd, @$_POST['daemon']);
                Yii::log('Installing JAR file '.$_POST['file']);
                break;
            }
            Yii::app()->end();
        }

        $file = array(
            'both'=>Yii::t('admin', 'JAR and Config'),
            'conf'=>Yii::t('admin', 'Config File'),
            'jar'=>Yii::t('admin', 'JAR File'),
        );

        $action = array(
            'update'=>Yii::t('admin', 'Update'),
            'start'=>Yii::t('admin', 'Download only'),
            'install'=>Yii::t('admin', 'Install'),
        );
        
        $model = new Daemon('search');
        $model->dbCriteria->order = 'id ASC';
        $model->unsetAttributes();
        if(isset($_GET['Daemon']))
            $model->attributes=$_GET['Daemon'];
                
        $this->render('updateMC',array(
            'file'=>$file,
            'action'=>$action,
            'model'=>$model,
        ));
    }

    public function runCmd($dmn, $cmd)
    {
        $errors = array();
        if ($dmn)
        {
            Yii::log('Running command "'.$cmd.'" on daemon '.$dmn);
            $ret = McBridge::get()->cmd($dmn, $cmd);
            if (!$ret['success'])
                $errors[] = CHtml::encode(Yii::t('admin', 'Daemon').' '.$dmn.': '.$ret['error']);
        }
        else
        {
            Yii::log('Running command "'.$cmd.'" on all daemons');
            $ret = McBridge::get()->globalCmd($cmd);
            foreach ($ret as $id=>$r)
                if (!$r['success'])
                    $errors[] =  CHtml::encode(Yii::t('admin', 'Daemon').' '.$id.': '.$r['error']);
        }
        if (count($errors))
            Yii::app()->user->setFlash('files-error', join("<br/>", $errors));
        else
            Yii::app()->user->setFlash('files-success', Yii::t('admin', 'Command successfully sent.'));
        //$this->redirect(array('files', 'daemon_id'=>$dmn));
    }

    public function filesFail($dmn, $error)
    {
        Yii::app()->user->setFlash('files-error', CHtml::encode($error));
    }

    public function actionFiles($daemon_id = 0)
    {
        $dmn = (int)(isset($_POST['daemon_id']) ? $_POST['daemon_id'] : $daemon_id);
        $errors = array();
        $cmd = false;
        if (isset($_POST['do_download']))
        {
            $target = $_POST['download-target'];
            if (!preg_match("/^[^\\/?*:;{}\\\n]+$/", $target))
                $this->filesFail($dmn, Yii::t('admin', 'Invalid file name specified.'));
            else
            {
                $protocols = '/^(ftp|ftps|http|https):\/\//';
                $file = $_POST['download-file'];
                $conf = $_POST['download-conf'];
                if ($file && !preg_match($protocols, $file))
                    $file = 'http://'.$file;
                if ($conf && !preg_match($protocols, $conf))
                    $conf = 'http://'.$conf;
                Yii::log('Starting download of JAR file '.$target.' from "'.$file.'", conf "'.$conf.'"');
                $this->runCmd($dmn, 'downloadjar '.$target.' :'.$file.' :'.$conf);
            }
        }
        else if (isset($_POST['do_delete']))
        {
            $target = $_POST['delete-target'];
            $file = $_POST['delete-file'];
            if (!preg_match("/^[^\\/?*:;{}\\\n]+$/", $target))
                $this->filesFail($dmn, Yii::t('admin', 'Invalid file name specified.'));
            else if (!in_array($file, array('both', 'file', 'conf')))
                $this->filesFail($dmn, Yii::t('admin', 'Please choose a file type to delete.'));
            else
            {
                Yii::log('Deleting JAR file '.$target.' ('.$file.')');
                $this->runCmd($dmn, 'deletejar '.$target.' :'.$file);

                $newJar = @$_POST['delete-switchto'];
                if (@strlen($newJar))
                {
                    Yii::log('Updating server JARs: "'.$target.'" -> "'.$newJar.'"');
                    if ($newJar === 'empty')
                        $newJar = '';
                    $svs = Server::model()->findAllByAttributes(array('jarfile'=>$target));
                    foreach ($svs as $sv)
                    {
                        $sv->jarfile = $newJar;
                        $sv->save();
                    }
                    Yii::log('Updated '.@count($svs).' servers');
                }
            }
        }

        $ret = McBridge::get()->globalCmd('updatejar list :');

        $jars = array();
        foreach ($ret as $id=>$r)
        {
            if (!$r['success'])
                continue;
             
            foreach ($r['data'] as $jar)
                $jars[$jar['jar']] = $jar['jar'].' ('.$jar['name'].')';
        }
        natcasesort($jars);

        $this->render('files',array(
            'daemon_id'=>$dmn,
            'jars'=>$jars,
        ));
    }

    public function actionStatus($id = 0)
    {
        if (isset($_POST['ajax']))
            Yii::app()->end();

        $model = new Daemon('search');
        $model->dbCriteria->order = 'id ASC';
        $model->unsetAttributes();
        if(isset($_GET['Daemon']))
            $model->attributes=$_GET['Daemon'];
                
        $this->render('status',array(
            'model'=>$model,
        ));
    }

    private function runServerAction($sv, $action, $params)
    {
        switch ($action)
        {
        case 'active_start':
            if (!McBridge::get()->serverCmd($sv->id, 'start'))
                return array(false, McBridge::get()->lastError());
            break;
        case 'active_stop':
            if (!McBridge::get()->serverCmd($sv->id, 'stop'))
                return array(false, McBridge::get()->lastError());
            break;
        case 'active_restart':
            if (!McBridge::get()->serverCmd($sv->id, 'restart'))
                return array(false, McBridge::get()->lastError());
            break;
        case 'active_suspend':
            if (!$sv->suspend())
                return array(false, CHtml::errorSummary($sv));
            else
                McBridge::get()->serverCmd($sv->id, 'stop');
            break;
        case 'suspended_resume':
            if (!$sv->resume())
                return array(false, CHtml::errorSummary($sv));
            break;
        default:
            return array(false, Yii::t('admin', 'Unknown action "{action}"', array('{action}'=>$action)));
            break;
        }
        return array(true, '');
    }

    public function actionOperations($id = 0)
    {
        if (isset($_POST['daemon_id']))
            $id = $_POST['daemon_id'];
        $all = ($id === 'all');
        $did = (int)$id;
        $action = false;
        $params = array();
        $acts = array(
            'active_start',
            'active_stop',
            'active_restart',
            'active_suspend',
            'suspended_resume',
            'run_chat',
            'run_stop',
            'run_restart',
            'run_console',
            'run_reloadconf',
            'global_clean_players',
            'global_clear_cmdcache',
        );
        foreach ($_POST as $k=>$v)
        {
            if (in_array($k, $acts))
            {
                $action = $k;
                break;
            }
            $params[$k] = $v;
        }
        if (($did || $all) && preg_match('/^run_/', $action))
        {
            $cmdPrefix = 'server running:';
            $cmd = substr($action, 4);
            if ($action == 'run_console')
            {
                if (!strlen(@$params['command']))
                {
                    Yii::app()->user->setFlash('operations', Yii::t('admin', 'No command to send.'));
                    $this->redirect(array('operations', 'id'=>$id));
                }
                $cmd = 'run_s:'.$params['command'];
            }
            else if ($action == 'run_chat')
            {
                if (!strlen(@$params['message']))
                {
                    Yii::app()->user->setFlash('operations', Yii::t('admin', 'No message to send.'));
                    $this->redirect(array('operations', 'id'=>$id));
                }
                $from = strlen(@$params['from']) ? $params['from'] : Yii::app()->user->name;
                $cmd = 'mc:say <'.$from.'> '.$params['message'];
            }
            else if ($action == 'run_reloadconf')
                $cmdPrefix = '';
            if ($all)
                $res = McBridge::get()->globalCmd($cmdPrefix.$cmd);
            else
                $res = array($did=>McBridge::get()->cmd($did, $cmdPrefix.$cmd));
            $msg = '';
            $runIds = array();
            $failIds = array();
            foreach ($res as $i=>$r)
            {
                if (@$r['success'])
                    $runIds[] = $i;
                else
                    $failIds[] = $i.': '.CHtml::encode(@$r['error']);
            }
            $msg = '';
            if (count($runIds))
                $msg .= Yii::t('admin', 'Action run for daemons:').'<br/>'.implode(', ', $runIds);
            if (count($failIds))
                $msg .= (count($runIds) ? '<br/><br/>' : '').Yii::t('admin', 'Action failed for daemons:').'<br/>'.implode(', ', $failIds);
            if (!strlen($msg))
                $msg = Yii::t('admin', 'No daemons affected');
            Yii::app()->user->setFlash('operations', $msg);
            $this->redirect(array('operations', 'id'=>$id) + $params);
        }
        else if (($did || $all) && preg_match('/^(active_|suspended_)/', $action))
        {
            $active = false;
            if (preg_match('/^active_/', $action))
                $active = true;
            $cond = array('suspended'=>($active ? 0 : 1));
            if (!$all)
                $cond['daemon_id'] = $did;
            $svs = Server::model()->findAllByAttributes($cond);

            $runIds = array();
            $failIds = array();

            foreach ($svs as $sv)
            {
                $res = $this->runServerAction($sv, $action, $params);
                if (!$res[0])
                    $failIds[] = $sv->id.': '.$res[1];
                else
                    $runIds[] = $sv->id;
            }
            $msg = '';
            if (count($runIds))
                $msg .= Yii::t('admin', 'Action run for servers:').'<br/>'.implode(', ', $runIds);
            if (count($failIds))
                $msg .= (count($runIds) ? '<br/><br/>' : '').Yii::t('admin', 'Action failed for servers:').'<br/>'.implode(', ', $failIds);
            if (!strlen($msg))
                $msg = Yii::t('admin', 'No servers affected');
            Yii::app()->user->setFlash('operations', $msg);
            $this->redirect(array('operations', 'id'=>$id) + $params);
        }
        else if (preg_match('/^global_/', $action))
        {
            if ($action == 'global_clean_players')
            {
                $sql = 'delete from `player` where `level`=1 or `level`=(select `default_level`'
                    .' from `server` where `id`=`server_id`)';
                $cmd = Yii::app()->bridgeDb->createCommand($sql);
                $del = $cmd->execute();
                Yii::log('Player table cleanup: Deleted '.$del.' player entries');
                Yii::app()->user->setFlash('operations', Yii::t('admin', 'Deleted {del} player entries.',
                    array('{del}'=>$del)));
                $this->redirect(array('operations', 'id'=>$id));
            }
            else if ($action == 'global_clear_cmdcache')
            {
                CommandCache::clear();
                Yii::log('Cleared command cache table');
                Yii::app()->user->setFlash('operations', Yii::t('admin', 'Cleared command cache table.'));
                $this->redirect(array('operations', 'id'=>$id));
            }
        }
                
        $this->render('operations',array('daemon_id'=>$id));
    }


    public function actionRemoveDaemon($id)
    {
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException(400, Yii::t('mc', 'Invalid request.'));
        Daemon::model()->deleteByPk($id);
        $this->redirect(array('status'));
    }

    public function actionStatistics()
    {
        if (isset($_POST['ajax']))
        {
            if ($_POST['ajax'] === 'stats')
            {
                $svs = Server::model()->findAllByAttributes(array('suspended'=>0));
                $players = 0;
                $servers = 0;
                $memory = 0;
                foreach ($svs as $sv)
                {
                    $pl = $sv->getOnlinePlayers();
                    if ($pl >= 0)
                    {
                        $servers++;
                        $players += $pl;
                        $memory += $sv->memory;
                    }
                }
                $data = array();
                $data['servers'] = $servers;
                $data['players'] = $players;
                $data['avg_players'] = $servers ? number_format($players / $servers, 2) : 0;
                $data['memory'] = number_format($memory).' '.Yii::t('admin', 'MB');
                header('Content-type: application/json');
                echo CJSON::encode($data);
            }
            Yii::app()->end();
        }

        $sql = 'select count(*), sum(`players`), sum(`memory`) from `server`';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $row = $cmd->queryRow(false);
        $servers = $row[0];
        $players = $row[1];
        $memory = $row[2];

        $sql = 'select sum(`memory`) from `daemon`';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $row = $cmd->queryRow(false);
        $totalMemory = $row[0];

        $sql = 'select count(*), sum(`players`), sum(`memory`) from `server` where `suspended`!=1';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $row = $cmd->queryRow(false);
        $activeServers = $row[0];
        $activePlayers = $row[1];
        $activeMemory = $row[2];

        $sql = 'select count(*) from `daemon`';
        $cmd = Yii::app()->bridgeDb->createCommand($sql);
        $dmns = $cmd->queryScalar();

        
        $this->render('statistics',array(
            'servers' => $servers,
            'activeServers' => $activeServers,
            'daemons' => $dmns,
            'svPerDaemon' => ($dmns ? ($servers / $dmns) : 0),
            'activeSvPerDaemon' => ($dmns ? ($activeServers / $dmns) : 0),
            'slots' => $players,
            'activeSlots' => $activePlayers,
            'memory' => $memory,
            'activeMemory' => $activeMemory,
            'totalMemory' => $totalMemory,
        ));
    }

    public function saveCfg($p)
    {
        $header = '<?php /*** THIS FILE WAS GENERATED BY THE MULTICRAFT FRONT-END ***/'."\n"
            .'return ';
        if (!isset($p['config']['panel_db'])
            || !isset($p['config']['daemon_db']))
            throw new CHttpException(500, 'Config file is missing critical settings.');
        $content = $header.var_export($p['config'], true).';';
        $saved = file_put_contents($p['config_file'], $content);
        if (function_exists('opcache_invalidate'))
            opcache_invalidate($p['config_file'], true);
        return $saved;
    }

    public function actionPanelConfig()
    {
        $p = array();
        $p['config_file'] = realpath(dirname(__FILE__).'/../config/').'/config.php';
        $cfg = require($p['config_file']);
        if (!is_array($cfg))
            $cfg = array();
        $p['config'] = $cfg;

        if (isset($_POST['submit_settings']))
        {
            foreach ($_POST['settings'] as $k=>$v)
            {
                if ($v == 'sel_true')
                    $v = true;
                else if ($v == 'sel_false')
                    $v = false;

                if ($v != @$p['config'][$k])
                    Yii::log('Panel setting "'.$k.'" changed to "'.$v.'"');

                $p['config'][$k] = $v;
            }
            //safety override
            $p['config']['panel_db'] = $cfg['panel_db'];
            $p['config']['panel_db_user'] = (string)@$cfg['panel_db_user'];
            $p['config']['panel_db_pass'] = (string)@$cfg['panel_db_pass'];
            $p['config']['daemon_db'] = $cfg['daemon_db'];
            $p['config']['daemon_db_user'] = (string)@$cfg['daemon_db_user'];
            $p['config']['daemon_db_pass'] = (string)@$cfg['daemon_db_pass'];
            $p['config']['daemon_password'] = $cfg['daemon_password'];
            Yii::log('Updating panel configuration');
            if (Yii::app()->params['demo_mode'] == 'enabled')
                Yii::app()->user->setFlash('panel_config', Yii::t('admin', 'Function disabled in demo mode.'));
            else if(!$this->saveCfg($p))
                Yii::app()->user->setFlash('panel_config', Yii::t('admin', 'Failed to save settings.'));
            if (@$p['config']['editable_roles'])
            {
                $sql = 'select count(*) from `role_permission`';
                $num = RolePermission::model()->dbConnection->createCommand($sql)->queryScalar();
                if (!$num)
                    RolePermission::reset('_all');
            }
            $this->redirect(array('panelConfig'));
        }

        $this->render('panelConfig',array(
            'p' => $p,
        ));
    }

    public function actionServerDefaults()
    {
        $model = new Server('superuser');
        $settings = new ServerConfig('superuser');
        if (isset($_POST['Server']))
        {
            $model->attributes = $_POST['Server'];
            $settings->attributes = $_POST['ServerConfig'];
        }
        $path = realpath(dirname(__FILE__).'/../config/');
        $cfg = $path.'/server_defaults.php';
        if ((!file_exists($cfg) && !is_writable($path)) || (file_exists($cfg) && !is_writable($cfg)))
        {
            Yii::app()->user->setFlash('server_error',
                Yii::t('admin', 'Config file not writable, settings will not be saved: protected/config/server_defaults.php'));
        }
        else if (isset($_POST['Server']))
        {
            $defaults = array(
                'server'=>$model->attributes,
                'config'=>$settings->attributes,
            );
            $saved = file_put_contents($cfg, '<?php return '.var_export($defaults, true).'; ?'.'>');
            if (function_exists('opcache_invalidate'))
                opcache_invalidate($cfg, true);
            $this->redirect(array('serverDefaults'));
        }
        $this->render('serverDefaults',array(
            'model'=>$model,
            'settings'=>$settings,
        ));
    }
}
