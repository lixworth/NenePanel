<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class UserController extends Controller
{
    public $layout='//layouts/column2';
    var $attribs = array();
    var $role = '';

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
                'actions'=>array('index', 'view', 'autocomplete'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('enableGauth', 'disableGauth'),
                'users'=>array('@'),
                'expression'=>'Yii::app()->params["enable_gauth"]',
            ),
            array('allow',
                'actions'=>array('create', 'update', 'delete'),
                'expression'=>'$user->isStaff()',
            ),
            array('allow',
                'actions'=>array('roles', 'editRole', 'resetRole'),
                'expression'=>'$user->isSuperuser() && Yii::app()->params["editable_roles"]',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $id = (int)$id;
        if (!Yii::app()->user->isStaff() && (Yii::app()->params['hide_userlist'] === true)
            && (((int)Yii::app()->user->id) !== $id))
        {
            throw new CHttpException(403, Yii::t('mc', 'You are not authorized to perform this action.'));
        }
        $model = $this->loadModel($id);
        $model->scenario = Yii::app()->user->isSuperuser() ? 'superuserUpdate' : 'update';
        
        if (Yii::app()->user->isStaff())
            $model->sendData = isset($_POST['User']['sendData']) ? $_POST['User']['sendData'] : true;

        $staffEdit = Yii::app()->user->isStaff() && !in_array($model->global_role, array('superuser', 'staff'));
        $edit = Yii::app()->user->isSuperuser()
            || ($staffEdit && $model->name != Yii::app()->user->superuser)
            || (Yii::app()->user->name == $model->name);

        if(isset($_POST['User']) && $edit)
        {
            if (Yii::app()->params['demo_mode'] == 'enabled' && in_array($model->name, array('admin', 'owner', 'user')))
            {
                Yii::app()->user->setFlash('user', Yii::t('mc', 'Function disabled in demo mode.'));
                $this->redirect(array('view','id'=>$model->id));
            }
            if (Yii::app()->user->name !== Yii::app()->user->superuser
                    && $model->name == Yii::app()->user->superuser)
            {
                Yii::app()->user->setFlash('user', Yii::t('mc', 'Access Denied'));
                $this->redirect(array('view','id'=>$model->id));
            }
            $nameBackup = $model->name;
            $pwBackup = $model->password;
            $emailBackup = $model->email;
            $globalRoleBackup = $model->global_role;
            $themeBackup = $model->theme;
            $model->attributes=$_POST['User'];
            if (!strlen($_POST['User']['password']))
                $model->password = $pwBackup;
            if (Yii::app()->user->name == $model->name) // edit self, require confirmation for superuser as well
            {
                if (strlen($_POST['User']['password']) || $emailBackup != $model->email)
                {
                    if (!@strlen($_POST['oldPassword']))
                        $model->addError('oldPassword', Yii::t('mc', 'Enter current password to confirm the changes.'));
                    else if (!Yii::app()->user->verifyPassword($_POST['oldPassword']))
                        $model->addError('oldPassword', Yii::t('mc', 'Incorrect password'));
                }
                if (strlen($_POST['User']['password']) && $model->password != $model->confirmPassword)
                    $model->addError('confirmPassword', Yii::t('mc', 'New Password must be repeated exactly.'));
            }
            if (!(Yii::app()->user->isSuperuser() || $staffEdit) || $model->name == Yii::app()->user->superuser
                || $nameBackup == Yii::app()->user->superuser)
                $model->name = $nameBackup;
            if (!Yii::app()->user->isSuperuser())
                $model->global_role = $globalRoleBackup;
            if (!(Yii::app()->user->isSuperuser() || $staffEdit || Yii::app()->params['user_theme'] === true))
                $model->theme = $themeBackup;
            if($model->validate(null, false) && $model->save(false))
            {
                if (Yii::app()->user->isSuperuser() && isset($_POST['global_ftp_access']))
                {
                    $access = in_array($_POST['global_ftp_access'], array('ro', 'rw')) ? $_POST['global_ftp_access'] : '';
                    $model->setServerFtpAccess(0, $access);
                }
                Yii::log('Updated user '.$model->id);
                Yii::app()->user->setFlash('user', Yii::t('mc', 'User saved.'));
                $this->redirect(array('view','id'=>$model->id));
            }
        }
        else if (isset($_POST['action']) && (($edit && Yii::app()->params['user_api_keys'] === true) || Yii::app()->user->isSuperuser()))
        {
            switch ($_POST['action'])
            {
            case 'new_api_key':
                $model->generateApiKey();
                $model->save(false);
                Yii::log('Generated API key for user '.$model->id);
                Yii::app()->user->setFlash('user', Yii::t('mc', 'New API key generated.'));
                $this->redirect(array('view','id'=>$model->id));
                break;
            case 'del_api_key':
                $model->api_key = '';
                $model->save(false);
                Yii::log('Deleted API key for user '.$model->id);
                Yii::app()->user->setFlash('user', Yii::t('mc', 'API key deleted.'));
                $this->redirect(array('view','id'=>$model->id));
                break;
            }
        }
        $model->password = '';
        $model->confirmPassword = '';

        $allRoles = array_combine(User::$roles, User::getRoleLabels());
        $allRoles['staff'] = Yii::t('mc', 'Staff');
        $allRoles['superuser'] = Yii::t('mc', 'Superuser');

        $servers = array();
        $spp = 10;
        if (Yii::app()->user->isStaff())
        {
            if ($spp = Setting::model()->findByPk('serversPerPage'))
                $spp = max(1, (int)$spp->value);
            $sql = 'select `server_id` from `user_server` where `user_id`=? and `role`=\'owner\'';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(1, $model->id);
            $ids = $cmd->queryColumn();
            $servers = Server::model()->findAllByAttributes(array('id'=>array_values($ids)));
        }
        $this->render('view',array(
            'model'=>$model,
            'allRoles'=>$allRoles,
            'staffEdit'=>$staffEdit,
            'edit'=>$edit,
            'servers'=>new CArrayDataProvider($servers, array(
                'sort'=>array(
                    'attributes'=>array(
                        'name', 
                    ),
                ),
                'pagination'=>array('pageSize'=>$spp),
            )),
        ));
    }

    public function actionCreate()
    {
        $model=new User('create');
        $model->sendData = isset($_POST['User']['sendData']) ? $_POST['User']['sendData'] : true;
        $staffEdit = Yii::app()->user->isStaff() && !in_array($model->global_role, array('superuser', 'staff'));

        if(isset($_POST['User']))
        {
            $globalRoleBackup = $model->global_role;
            $model->attributes=$_POST['User'];
            if (!strlen($model->password) &&  Yii::app()->params['mail_welcome'])
                $model->password = substr(md5(rand().$model->name), 5, 13);
            if (!Yii::app()->user->isSuperuser())
                $model->global_role = $globalRoleBackup;
            if($model->save())
            {
                Yii::log('Created user '.$model->id);
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $allRoles = array_combine(User::$roles, User::getRoleLabels());
        $allRoles['staff'] = Yii::t('mc', 'Staff');
        $allRoles['superuser'] = Yii::t('mc', 'Superuser');

        $this->render('view',array(
            'model'=>$model,
            'allRoles'=>$allRoles,
            'staffEdit'=>$staffEdit,
            'edit'=>true,
        ));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if (Yii::app()->params['demo_mode'] == 'enabled' && in_array($model->name, array('admin', 'owner', 'user')))
        {
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Function disabled in demo mode.'));
            $this->redirect(array('view','id'=>$model->id));
        }
        if(Yii::app()->request->isPostRequest)
        {
            if (!Yii::app()->user->isSuperuser() && in_array($model->global_role, array('superuser', 'staff')))
                throw new CHttpException(400,Yii::t('mc', 'Access Denied'));
            if ($model->name != Yii::app()->user->superuser)
            {
                Yii::log('Deleting user '.$model->id);
                $model->delete();   
            }

            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('mc', 'Invalid request.'));
    }

    public function actionIndex()
    {
        if (!Yii::app()->user->isStaff() && Yii::app()->params['hide_userlist'])
            throw new CHttpException(403, Yii::t('mc', 'You are not authorized to perform this action.'));
        $model=new User(Yii::app()->user->isStaff() ? 'search' : 'userSearch');
        $model->unsetAttributes();
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionAutocomplete($server_id = 0)
    {
        if (Yii::app()->user->isStaff())
            $sv = null;
        else if ($server_id)
        {
            $sv = Server::model()->findByPk((int)$server_id);
            if (!$sv || !Yii::app()->user->can($sv->id, 'manage_users'))
                return '[]';
        }
        else
            return '[]';

        $res = array();
        if (isset($_GET['term']))
        {
            $crit = new CDbCriteria();
            $crit->select = '`id`, `name`';
            $crit->order = '`name` asc';
            $crit->limit = 10;
            if ($sv)
            {
                $crit->addCondition('(select `role` from `user_server` where `server_id`=:server and `user_id`=`id`)!=\'\'');
                $crit->params = array(':server'=>$sv->id);
            }
            $crit->compare('`name`', (string)$_GET['term'], true);
            foreach (User::model()->findAll($crit) as $user)
                $res[] = $user->name;
        }
        header('Content-type: application/json');
        echo CJSON::encode($res);
    }

    public function actionRoles()
    {
        $this->render('roles', array(
        ));
    }

    public function heading($title)
    {
        $this->attribs[] = array('label'=>CHtml::tag('h5', array(), $title), 'type'=>'raw', 'value'=>CHtml::submitButton('Save'));
    }

    public function checkbox($permission, $hint = '')
    {
        $this->attribs[] = array('label'=>CHtml::label(RolePermission::label($permission), $permission), 'type'=>'raw',
            'value'=>CHtml::checkBox($permission, RolePermission::has($this->role, $permission)),
            'hint'=>$hint);
    }

    public function saveButton()
    {
        $this->attribs[] = array('label'=>'', 'type'=>'raw',
            'value'=>CHtml::submitButton('Save'),
            'hint'=>'');
        if (count($this->attribs))
            $this->widget('zii.widgets.CDetailView', array('data'=>array(),'attributes'=>$this->attribs));
    }

    public function actionEditRole($role)
    {
        if (!in_array($role, User::$roles))
            throw new CHttpException(404, Yii::t('mc', 'The requested page does not exist.'));
        $this->role = $role;

        if (isset($_POST['role']))
        {
            if ($_POST['role'] !== $role)
                Yii::app()->user->deny();
            $permissions = RolePermission::getPermissions();
            RolePermission::model()->deleteAllByAttributes(array('role'=>$role));
            foreach ($_POST as $k=>$v)
            {
                if (!isset($permissions[$k]) || !$v)
                    continue;
                $rp = new RolePermission;
                $rp->role = $role;
                $rp->permission = $k;
                if (!$rp->save())
                    die(Yii::t('mc', 'Failed to save role permission: {error}', array('{error}'=>CHtml::encode(print_r($rp->getErrors(), true)))));
            }
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Role permissions updated.'));
            $this->redirect(array('roles'));
        }
        $this->render('editRole',array(
            'role'=>$role,
        ));
    }

    public function actionResetRole($role)
    {
        if(!Yii::app()->request->isPostRequest)
            Yii::app()->user->deny();
        if (RolePermission::reset($role))
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Role(s) reset.'));
        else
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Error reseting role(s).'));
        if ($role == '_all')
            $this->redirect(array('roles'));
        else
            $this->redirect(array('editRole', 'role'=>$role));
    }

    public function loadModel($id)
    {
        $model=User::model()->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,Yii::t('mc', 'The requested page does not exist.'));
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionEnableGauth($id, $step = 1)
    {
        $model = $this->loadModel($id);

        if ($model->id !== Yii::app()->user->model->id)
            Yii::app()->user->deny();

        if ($model->gauthEnabled())
        {
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Google Authenticator is already enabled'));
            $this->redirect(array('view', 'id'=>$model->id));
        }

        Yii::import('application.extensions.gauth.GoogleAuthenticator');

        $g = new GoogleAuthenticator();

        if ($step === 1)
        {
            $secret = $g->createSecret();
            Yii::app()->user->setState('_gauth_temp_secret', $secret);
            $this->redirect(array('enableGauth', 'id'=>$model->id, 'step'=>2));
        }
        else
        {
            $secret = Yii::app()->user->getState('_gauth_temp_secret');
            if (strlen($secret) < 16)
                throw new CHttpException(500, Yii::t('mc', 'PHP Session support needs to be enabled for Google Authenticator to work'));
        }

        if (isset($_POST['User']))
        {
            if (!$g->verifyCode($secret, $_POST['User']['gauth_token']))
                $model->addError('gauth_token', Yii::t('mc', 'Invalid verification code'));
            if ($model->password !== crypt($_POST['User']['confirmPassword'], $model->password))
                $model->addError('confirmPassword', Yii::t('mc', 'Incorrect password'));
            if (!$model->hasErrors())
            {
                $model->gauth_secret = $secret;
                $model->gauth_token = substr(md5($_POST['User']['gauth_token']), 16, 16);
                Yii::app()->user->setState('gauth_token', md5($model->gauth_token));
                if ($model->save())
                {
                    Yii::app()->user->setState('_gauth_temp_secret', null);
                    Yii::app()->user->setFlash('user', Yii::t('mc', 'Google Authenticator enabled'));
                    $this->redirect(array('user/view', 'id'=>$model->id));
                }
            }
        }
        
        $domain = @Yii::app()->params['gauth_domain'];
        if (!$domain)
            $domain = $_SERVER['SERVER_NAME'];
        $qr = $g->getQRCodeGoogleUrl($model->name.'@'.$domain, $secret, 'Multicraft');
        $model->gauth_token = '';
        $this->render('enableGauth', array(
            'model'=>$model,
            'domain'=>$model->name.'@'.$domain,
            'secret'=>$secret,
            'qr'=>$qr,
        ));
    }

    public function actionDisableGauth($id)
    {
        $model = $this->loadModel($id);

        $staffEdit = Yii::app()->user->isStaff() && !in_array($model->global_role, array('superuser', 'staff'));
        $edit = Yii::app()->user->isSuperuser()
            || ($staffEdit && $model->name != Yii::app()->user->superuser)
            || (Yii::app()->user->name == $model->name);

        if (!$edit)
            Yii::app()->user->deny();

        if (!$model->gauthEnabled())
        {
            Yii::app()->user->setFlash('user', Yii::t('mc', 'Google Authenticator is already disabled'));
            $this->redirect(array('view', 'id'=>$model->id));
        }

        if (isset($_POST['User']))
        {
            if (Yii::app()->user->model->id === $model->id
                && $model->password !== crypt($_POST['User']['confirmPassword'], $model->password))
                $model->addError('confirmPassword', Yii::t('mc', 'Incorrect password'));
            if (!$model->hasErrors())
            {
                $model->gauth_secret = '';
                $model->gauth_token = '';
                Yii::app()->user->setState('gauth_token', null);
                if ($model->save())
                {
                    Yii::app()->user->setFlash('user', Yii::t('mc', 'Google Authenticator disabled'));
                    $this->redirect(array('user/view', 'id'=>$model->id));
                }
            }
        }
        
        $this->render('disableGauth', array(
            'model'=>$model,
        ));
    }
}
