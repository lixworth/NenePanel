<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

Yii::import('zii.widgets.CMenu');

class Menu extends CMenu
{
    protected function renderMenuItem($item)
    {
        if (isset($item['icon']))
        {
            if (!is_array($item['icon']))
                $icons = array($item['icon']);
            else
                $icons = $item['icon'];
            $hide = false;
            foreach ($icons as $icon)
            {
                $item['label'] = $item['label'].Theme::icon($icon, $hide ? array('style' => 'display: none') : array());
                $hide = true;
            }
        }
        return parent::renderMenuItem($item);
    }
}



