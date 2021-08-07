<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class McBridgeDemo extends McBridge
{
    public $responses = array();
    private static $inst = null;
    private static $con = null;
    private $connections = array();
    
    private function __construct()
    {
    }
    
    static function get()
    {
        if (!McBridgeDemo::$inst)
            McBridgeDemo::$inst = new McBridgeDemo();
        return McBridgeDemo::$inst;
    }

    public function getConnection($id)
    {
        if (@isset($this->connections[$id]))
            return $this->connections[$id];
        $daemon = Daemon::model()->findByPk((int)$id);
        if (!$daemon)
            return null;
        $con = new McConnectionDemo($this, $id, $daemon->name, $daemon->ip, $daemon->port, '', '');
        return ($this->connections[$id] = $con);
    }
}

