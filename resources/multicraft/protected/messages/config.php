<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
    'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
    'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
    'languages'=>array('de', 'empty'),
    'fileTypes'=>array('php'),
    'overwrite'=>true,
    'exclude'=>array(
        'CVS',
        '.hg',
        '.svn',
        '/protected/yiilite.php',
        '/protected/yiit.php',
        '/protected/data',
        '/protected/i18n/data',
        '/protected/messages',
        '/protected/runtime',
        '/protected/tests',
        '/protected/vendors',
        '/protected/web/js',
        '/protected/yii',
    ),
);
