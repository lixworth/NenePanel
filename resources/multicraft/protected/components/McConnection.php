<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class McConnection extends McErrors
{
    var $id;
    var $name;
    var $ip;
    var $port;
    var $password;
    var $token;
    var $socket;
    var $socketTimeout;
    var $bridge;
    var $triedConnect = false;
    var $connectError = '';
    var $markOffline = 0;

    function __construct($bridge, $id, $name, $ip, $port, $password, $token)
    {
        $this->bridge = $bridge;
        $this->id = $id;
        $this->name = $name;
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
        $this->token = $token;
        $this->socketTimeout = $bridge->socketTimeout;
        $this->markOffline = $bridge->markOffline;
        $this->socket = false;        
    }

    function command($cmd, &$data)
    {
        $cmd = str_replace("\n", " ", $cmd);
        $error = '';
        if ($this->markOffline > 0 && CommandCache::get($this->id, 'daemon down', $error, $this->markOffline) > 0)
        {
            $this->connectError = $error;
            $this->addError($this->connectError);
            return false;
        }
        if (!$this->send($cmd))
        {
            if ($this->markOffline > 0)
                CommandCache::set($this->id, 'daemon down', $this->connectError);
            return false;
        }
        $r = $this->recv();
        if (!$r['ack'])
            return false;
        $data = McBridge::parse($r['data']);
        return true;
    }
    public function connect()
    {
        if ($this->triedConnect)
        {
            $this->addError($this->connectError);
            return false;
        }
        $this->triedConnect = true;
        $this->connectError = '';
        $errno = 0; $errstr = '';
        $this->socket = @fsockopen($this->ip, $this->port, $errno, $errstr, $this->socketTimeout);
        if (!$this->socket)
        {
            $this->connectError = Yii::t('mc', 'Can\'t connect to daemon').' '.Yii::t('mc', '({errno}: {errstr})',
                array('{errno}'=>$errno, '{errstr}'=>$errstr));
            $this->addError($this->connectError);
            $this->socket = false;
            return false;
        }
        stream_set_timeout($this->socket, $this->socketTimeout);

        //clear stream (in case we're using persistent connections)
        while ($this->dataReady())
            if (!fgets($this->socket))
                break;
        if (!$this->connected())
        {   
            $this->connectError = Yii::t('mc', 'Can\'t connect to daemon').' '.Yii::t('mc', '(connection lost)');
            $this->addError($this->connectError);
            $this->socket = false;
            return false;
        }
        return true;
    }

    public function auth()
    {
        $data = false;
        if (!$this->command('auth '.substr($this->token, 2, 12), $data))
        {
            $this->disconnect();
            $this->addError(Yii::t('mc', 'Authentication failed').' '.Yii::t('mc', '(auth: {error})',
                array('{error}'=>$this->lastError())));
            return false;
        }
        $token = @$data[0]['token'];
        $sign = @$data[0]['sign'];
        if (!$sign && (@Yii::app()->params['support_legacy_daemons'] === true))
        {
            if (!$token)
                return true;
        }
        else if ($sign !== substr($this->token, 16, 12))
        {
            $this->disconnect();
            $this->addError(Yii::t('mc', 'Authentication failed').' '.Yii::t('mc', '(code: {error})',
                array('{error}'=>Yii::t('mc', 'Invalid signature'))));
            return false;
        }
        if ($token === '=')
            return true;
        else if (preg_match('/^([0-9]+)$/', $token))
        {
            $code = base64_encode(sha1($token.sha1(sha1($this->password))) ^ sha1($this->password));
            //echo "CODE: $code";
            if (!$this->command('codeword: '.$code, $none))
            {
                $this->disconnect();
                $this->addError(Yii::t('mc', 'Authentication failed').' '.Yii::t('mc', '(code: {error})',
                    array('{error}'=>$this->lastError())));
                return false;
            }
            return true;
        }
        return false;
    }

    public function connected()
    {
        return $this->socket !== false;
    }
    
    public function dataReady()
    {
        if (!$this->connected())
            return false;
        $r = array($this->socket);
        $w = null;
        $x = null;
        return @stream_select($r, $w, $x, 0) > 0;
    }

    public function send($data)
    {
        if (!$this->connected())
        {
            if (!$this->bridge->autoconnect)
            {
                $this->addError(Yii::t('mc', 'Not connected!'));
                return false;
            }
            if (!$this->connect() || !$this->auth())
               return false; 
        }
        if (@fwrite($this->socket, $data."\n") === false)
        {
            $this->addError(Yii::t('mc', 'Send failed!'));
            return false;
        }
        return true;
    }

    public function recv()
    {
        if (!$this->connected())
        {
            $this->addError(Yii::t('mc', 'Not connected!'));
            return false;
        }
        $ret = array();
        $ret['ack'] = false;
        $ret['error'] = Yii::t('mc', 'Data receive timeout');
        $ret['data'] = array();

        $prev = '';
        while(true)
        {
            $r = fgets($this->socket);
            $data = $prev.$r;
            $prev = $data;
            if ($r && $data[strlen($data)-1] != "\n")
                continue;
            if (strlen($data) && $data[0] == '>')
            {
                if ($data[1] != 'O')
                {
                    $ret['error'] = preg_replace('/ERROR( - )?/', '', substr($data, 1, strlen($data) - 2));
                    //$this->addError($ret['error']);
                }
                else
                {
                    $ret['ack'] = true;
                    $ret['error'] = false;
                }
                if ($this->dataReady())
                {
                    //We somehow have a second response on the stream, discard current response
                    $ret['ack'] = false;
                    $ret['error'] = false;
                    $ret['data'] = array();
                    $prev = '';
                }
                else
                    break;
            }
            else if (!$data)
            {
                if (!$ret['ack'])
                    $ret['error'] = Yii::t('mc', 'Empty response');
                break;
            }
            else
            {
                $prev = '';
                $ret['data'][] = substr($data, 1, strlen($data) - 2);
            }
        }
        if (!$ret['ack'])
            $this->addError($ret['error']);
        return $ret;
    }

    public function disconnect()
    {
        if (!$this->connected())
            return;
        fclose($this->socket);
        $this->socket = false;
        $this->triedConnect = false;
    }
}
