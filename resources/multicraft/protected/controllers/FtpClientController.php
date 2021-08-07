<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class FtpClientController extends Controller
{
    public $layout='//layouts/column2';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array((Yii::app()->params['ftp_client_disabled'] === true) ? 'deny' : 'allow',
                'actions'=>array('index', 'login', 'browse', 'createAccount'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($id = 0)
    {
        $this->redirect(array('ftpClient/login', 'id'=>(int)$id));
    }

    public function getFtpServer($server)
    {
        $daemon = Daemon::model()->findByPk((int)$server->daemon_id);
        if (!$daemon)
            throw new CHttpException(404, Yii::t('mc', 'No daemon found for this server.'));
        if (!isset($daemon->ftp_ip) || !isset($daemon->ftp_port))
            throw new CHttpException(500, Yii::t('mc', 'Daemon database not up to date, please run the Multicraft installer.'));
        return array('ip'=>$daemon->ftp_ip, 'port'=>$daemon->ftp_port);
    }

    public function getUsername($server)
    {
        return Yii::app()->user->name.'.'.$server->id;
    }

    public function net2FtpDefines()
    {
        define("NET2FTP_APPLICATION_ROOTDIR", dirname(__FILE__).'/../extensions/net2ftp/');
        if     (isset($_SERVER["SCRIPT_NAME"]) == true) { define("NET2FTP_APPLICATION_ROOTDIR_URL", dirname($_SERVER["SCRIPT_NAME"])); }
        elseif (isset($_SERVER["PHP_SELF"]) == true)    { define("NET2FTP_APPLICATION_ROOTDIR_URL", dirname($_SERVER["PHP_SELF"])); }
    }

    public function actionLogin($id = 0)
    {
        $server = Server::model()->findByPk((int)$id);
        if (!$server)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        if (isset($_POST['password']))
        {
            $pw = $_POST['password'];
            $this->net2FtpDefines();
            global $net2ftp_result, $net2ftp_settings, $net2ftp_globals;
            require_once(dirname(__FILE__).'/../extensions/net2ftp/includes/main.inc.php');
            require_once(dirname(__FILE__).'/../extensions/net2ftp/includes/authorizations.inc.php');
            $ftpSv = $this->getFtpServer($server);
            if (strlen($pw))
            {
                $_SESSION['net2ftp_password_encrypted'] = encryptPassword($pw);
                $sessKey = 'net2ftp_password_encrypted_'.$ftpSv['ip'].$this->getUsername($server);
                unset($_SESSION[$sessKey]);
            }
            Yii::log('Logging in to FTP server for server '.$server->id);
            $this->redirect(array('ftpClient/browse', 'id'=>$server->id));
        }

        $daemon = Daemon::model()->findByPk($server->daemon_id);
        $access = Yii::app()->user->model->getServerFtpAccess($server->id);
        $permissions = ($access == 'rw' ? 'elradfmw' : ($access == 'ro' ? 'elr' : ''));

        $this->render('login',array(
            'server'=>$server,
            'havePw'=>isset($_SESSION['net2ftp_password_encrypted']),
            'daemon'=>$daemon,
            'permissions'=>$permissions,
        ));
    }

    public function actionCreateAccount($id)
    {
        if(!Yii::app()->request->isPostRequest)
            Yii::app()->user->deny();
        Yii::app()->user->can($id, 'manage_users', true);
        $server = Server::model()->findByPk((int)$id);
        if (!$server)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        $cfg = ServerConfig::model()->findByPk($server->id);
        if ($server->id && (Yii::app()->user->isStaff() || (Yii::app()->user->can($id, 'manage_ftp') && $cfg->user_ftp)))
            Yii::app()->user->model->setServerFtpAccess($server->id, 'rw');
        else
            Yii::app()->user->deny();
        $this->redirect(array('ftpClient/login', 'id'=>$server->id));
    }

    public function actionBrowse($id, $partial = false)
    {
        $server = Server::model()->findByPk((int)$id);
        if (!$server)
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));

        if (@$_POST['ajax'] === 'refresh')
        {
            header('Content-type: application/json');
            echo CJSON::encode($this->ajaxRefresh($server, array('log')));
            Yii::app()->end();
        }

        if (!@Yii::app()->params['ftp_client_web_zip'])
            $this->injectZip($server);

        $this->net2FtpDefines();
        global $net2ftp_result, $net2ftp_settings, $net2ftp_globals;
        require_once(dirname(__FILE__).'/../extensions/net2ftp/includes/main.inc.php');
        require_once(dirname(__FILE__).'/../extensions/net2ftp/includes/errorhandling.inc.php');

        $ftpSv = $this->getFtpServer($server);
        $sessKey = 'net2ftp_password_encrypted_'.$ftpSv['ip'].$this->getUsername($server);
        if (!isset($_SESSION[$sessKey]))
        {
            if (!isset($_SESSION['net2ftp_password_encrypted']))
            {
                Yii::log('No valid FTP session found, redirecting to login form');
                $this->redirect(array('ftpClient/login', 'id'=>$server->id));
            }
            $_SESSION[$sessKey] = $_SESSION['net2ftp_password_encrypted'];
        }
        
        set_error_handler('net2ftpErrorHandler');

        if (!@$_REQUEST['state'])
        {
            $net2ftp_globals['state'] = 'browse';
            $net2ftp_globals['state2'] = 'main';
        }
        else
        {
            $net2ftp_globals['state'] = $_REQUEST['state'];
            $net2ftp_globals['state2'] = $_REQUEST['state2'];
        }

        $net2ftp_globals['ftpserver'] = $ftpSv['ip'];
        $net2ftp_globals['ftpserverport'] = $ftpSv['port'];
        $net2ftp_globals['language'] = Yii::app()->language;
        $net2ftp_globals['username'] = $this->getUsername($server);
        $net2ftp_globals['sslconnect'] = !!Yii::app()->params['ftp_client_ssl'];
        $net2ftp_globals['passivemode'] = Yii::app()->params['ftp_client_passive'] ? 'yes' : 'no';
        $net2ftp_globals['action_url'] = CHtml::normalizeUrl(array('browse', 'id'=>$server->id, 'partial'=>$partial));
        net2ftp("sendHttpHeaders");
        //print_r($net2ftp_globals);

        if ($net2ftp_result["success"] == false)
            throw new CHttpException(404, Yii::t('mc', 'Error in the FTP client module.'));

        ob_start();
        net2ftp("printJavascript");
        $js = ob_get_contents();
        ob_clean();
        net2ftp("printCss");
        $css = ob_get_contents();
        ob_clean();
        net2ftp("printBodyOnload");
        $onload = ob_get_contents();
        ob_clean();
        global $controller;
        $controller = $this;
        net2ftp("printBody");
        $body = ob_get_contents();
        ob_clean();

        if ($net2ftp_result["success"] == false)
        {
            require_once($net2ftp_globals["application_rootdir"]."/skins/"
                .$net2ftp_globals["skin"]."/error.template.php");
            $body = ob_get_contents();
            ob_clean();
        }
        
        $func = $partial ? 'renderPartial' : 'render';
        $this->$func('browse',array(
            'js'=>$js,
            'css'=>$css,
            'onload'=>$onload,
            'body'=>$body,
            'server'=>$server,
        ));
    }

    public function encode($arr)
    {
        $out = '';
        foreach ($arr as $elem)
        {
            if (preg_match('/[" ]/', $elem))
                $elem = '"'.str_replace('"', '""', $elem).'"';
            $out .= ($out ? ' ' : '').$elem;
        }
        return $out;
    }

    public function relative($path)
    {
        return preg_replace('/^\\/+/', '', ''.$path);
    }

    public function injectZip($server)
    {
        if (isset($_POST) && @$_POST['screen'] == 2 && Yii::app()->user->model->getServerFtpAccess($server->id) === 'rw')
        {
            $browse = true;
            if ($_POST['state'] == 'zip')
            {
                $dir = $this->relative(@$_POST['directory']);
                $dir = $dir ? $dir.'/' : '';
                $zip = $this->relative(@$_POST['zipactions']['save_filename']);
                if ($zip)
                {
                    $zip = $dir.$zip;
                    $cmd = array($zip);
                    foreach ($_POST['list'] as $entry)
                    {
                        if (!@$entry['dirfilename'])
                            continue;
                        $file = $this->relative($entry['dirfilename']);
                        if (!$file)
                            $file = '.';
                        $cmd[] = $dir.$file;
                    }
                    $ret = McBridge::get()->serverCmd($server->id, 'run_s:builtin:script _zip '.$this->encode($cmd));
                }
            }
            else if ($_POST['state'] == 'unzip')
            {
                $dir = $this->relative(@$_POST['directory']);
                $dir = $dir ? $dir.'/' : '';
                foreach ($_POST['list'] as $entry)
                {
                    $cmd = array();
                    $zip = $this->relative(@$entry['dirfilename']);
                    if (!$zip)
                        continue;
                    $target = $this->relative(@$entry['targetdirectory']);
                    if (!$target)
                        $target = '.';
                    $cmd[] = $dir.$zip;
                    $cmd[] = $target;
                    $ret = McBridge::get()->serverCmd($server->id, 'run_s:builtin:script _unzip '.$this->encode($cmd));
                }
            }
            else
                $browse = false;
            if ($browse)
            {
                $this->menu = array(
                    array('label'=>Yii::t('mc', 'Back'), 'url'=>array('ftpClient/browse', 'directory'=>@$_REQUEST['directory'],
                        'id'=>@$_GET['id']), 'icon'=>'back'),
                );
                $this->render('log',array(
                    'js'=>'',
                    'css'=>'',
                    'onload'=>'',
                    'body'=>Yii::t('mc', 'Command sent, check the server log for status'),
                    'server'=>$server,
                    'data'=>$this->ajaxRefresh($server, array('log')),
                ));
                Yii::app()->end();
            }
        }
    }
    private function ajaxRefresh($server, $type)
    {
        $all = ($type === 'all');
        if (!is_array($type))
            $type = array($type);
        $ret = array();

        $status = False;
        $seq = 0;

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
                {
                    $re = '/\\[Script .*zip\\]\s*(\\[.*zip\\])? /';
                    if (!preg_match($re, ''.@$log[$i]['line']."\n"))
                        continue;
                    echo preg_replace($re, '', ''.@$log[$i]['line']."\n");
                    if (!$seq)
                        $seq = @$log[$i]['s'];
                }
            }
            $ret['log'] = ob_get_clean();
            $ret['log_seq'] = $seq;
        }
        return $ret;
    }
}
