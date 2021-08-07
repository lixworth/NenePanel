<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/

class Theme extends CTheme
{
    private $_vpath = '';
    static $_cfg = null;

    static function slash($file)
    {
        if (strlen($file) && $file[0] != '/')
            $file = '/'.$file;
        return $file;
    }

    static function themeFilePath($file)
    {
        $file = Theme::slash($file);
        if (Yii::app()->theme && file_exists(Yii::app()->theme->basePath.$file))
            return Yii::app()->theme->basePath.$file;
        return Yii::getPathOfAlias('webroot').'/'.$file;
    }

    static function themeFile($file)
    {
        $file = Theme::slash($file);
        if (Yii::app()->theme && file_exists(Yii::app()->theme->basePath.$file))
            return Yii::app()->theme->baseUrl.$file;
        return Yii::app()->baseUrl.$file;
    }

    static function css($file)
    {
        $file = Theme::slash($file);
        return Theme::themeFile('css'.$file);
    }

    static function js($file)
    {
        $file = Theme::slash($file);
        return Theme::themeFile('js'.$file);
    }

    static function img($file, $alt = '', $htmlOptions = array())
    {
        $file = Theme::slash($file);
        return CHtml::image(Theme::themeFile('images'.$file), $alt, $htmlOptions);
    }

    static function icon($icon, $htmlOptions = array())
    {
        $iconMap = Theme::cfg('iconMap', array());
        $iconString = isset($iconMap[$icon]) ? $iconMap[$icon] : (isset($iconMap['*']) ? $iconMap['*'] : $icon);
        $iconString = str_replace('{ICON}', $icon, $iconString);
        if (Theme::cfg('iconType', 'icon') == 'font')
        {
            if (isset($htmlOptions['class']))
            {
                $iconString = $htmlOptions['class'].' '.$iconString;
                unset($htmlOptions['class']);
            }
            return CHtml::tag('i', array_merge(array('class' => $iconString), $htmlOptions), '');
        }
        else
            return Theme::img('icons/'.$iconString.'.png', '', $htmlOptions);
    }

    public function getViewPath()
    {
        if ($this->_vpath)
            return $this->_vpath;
        if (preg_match('/platform'.preg_quote(DIRECTORY_SEPARATOR, '/').'/', $this->name))
            $this->_vpath = Yii::app()->basePath.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$this->name;
        else
            $this->_vpath = CTheme::getViewPath();
        return $this->_vpath;
    }

    static function cfg($key, $default)
    {
        if (!is_array(Theme::$_cfg))
        {
            Theme::$_cfg = @include(Theme::themeFilePath('config.php'));
            if (!Theme::$_cfg)
                Theme::$_cfg = array();
        }
        return isset(Theme::$_cfg[$key]) ? Theme::$_cfg[$key] : $default;
    }

    static function formatBytes($size) {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2).$units[$i];
    }
}
