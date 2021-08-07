<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

$this->redirect(array('server/index', 'my'=>(Yii::app()->user->isSuperuser() ? 0 : 1)));
