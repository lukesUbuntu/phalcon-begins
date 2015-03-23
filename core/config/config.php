<?php

// use myconfig library to help automatic task.
include_once APPFULLPATH.DS.'Libraries'.DS.'MyConfig.php';
$myconfig = new \Libraries\MyConfig();
$auto_base_uri = $myconfig->getBaseUri();
unset($myconfig);

$config_object = new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'admin',
        'password' => 'pass',
        'dbname' => 'v_phalconbegins',
        'charset' => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APPFULLPATH . '/controllers/',
        'modelsDir' => APPFULLPATH . '/models/',
        'viewsDir' => APPFULLPATH . '/views/',
        'libraryDir' => APPFULLPATH . '/Libraries/',
        'extendDir' => APPFULLPATH . '/Extend/',
        'cacheDir' => APPFULLPATH . '/cache/',
        'languageDir' => APPFULLPATH.'/language/',
        'baseUri' => $auto_base_uri,
    ),
    'language' => array(
        'defaultLang' => 'th',
        'availableLang' => array(
            'en' => array('name' => 'English', 'locale' => 'en'),
            'th' => array('name' => 'ไทย', 'locale' => 'th'),
        ),
        'fallbackLang' => 'en',
    )
));

unset($auto_base_uri);
return $config_object;