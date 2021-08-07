<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class LoginForm extends CFormModel
{
    public $name;
    public $password;
    public $rememberMe;
    public $ignoreIp;
    public $gauthCode;

    private $_identity;

    public function init()
    {
        parent::init();
        $this->ignoreIp = @Yii::app()->params['default_ignore_ip'];
    }

    public function rules()
    {
        return array(
            array('name, password', 'required'),
            array('name, password', 'length', 'max'=>128),
            array('rememberMe', 'boolean'),
            array('ignoreIp', 'boolean'),
            array('password, gauthCode', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>Yii::t('mc', 'Name'),
            'password'=>Yii::t('mc', 'Password'),
            'rememberMe'=>Yii::t('mc', 'Stay logged in'),
            'ignoreIp'=>Yii::t('mc', 'Allow IP changes'),
            'gauthCode'=>Yii::t('mc', 'Google Authenticator Code'),
        );
    }

    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new UserIdentity($this->name, $this->password);
            $this->_identity->authenticate($this->ignoreIp, $this->gauthCode);
            if ($this->_identity->errorCode === UserIdentity::ERROR_GAUTH_CODE_INVALID)
                $this->addError('gauthCode', Yii::t('mc', 'Invalid authentication code.'));
            else if ($this->_identity->errorCode !== UserIdentity::ERROR_NONE)
                $this->addError('password',Yii::t('mc', 'Incorrect username or password.'));
        }
    }

    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->name,$this->password);
            $this->_identity->authenticate($this->ignoreIp, $this->gauthCode);
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $model = User::model()->findByAttributes(array('id'=>$this->_identity->_id));
            if ($model->gauthEnabled())
            {
                $model->gauth_token = substr(md5($this->gauthCode), 16, 16);
                $model->save();
                $this->_identity->setState('gauth_token', md5($model->gauth_token));
            }
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }

    public function gauthEnabled()
    {
        if (!@Yii::app()->params['enable_gauth'])
            return false;
        $model = User::model()->findByAttributes(array('name'=>$this->name));
        return $model && $model->gauthEnabled();        
    }
}
