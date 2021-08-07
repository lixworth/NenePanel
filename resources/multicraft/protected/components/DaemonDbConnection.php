<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class DaemonDbConnection extends DbConnection
{
    public function init()
    {
        $this->type = 'daemon';
        parent::init();
    }
}
