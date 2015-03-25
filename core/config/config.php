<?php

// use myconfig library to help automatic task.
include_once APPFULLPATH.DS.'libraries'.DS.'MyConfig.php';
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
        'tablePrefix' => 'ws_',
    ),
    'application' => array(
        'controllersDir' => APPFULLPATH . '/controllers/',
        'modelsDir' => APPFULLPATH . '/models/',
        'viewsDir' => APPFULLPATH . '/views/',
        'libraryDir' => APPFULLPATH . '/libraries/',
        'extendDir' => APPFULLPATH . '/extend/',
        'cacheDir' => APPFULLPATH . '/cache/',
        'logDir' => APPFULLPATH . '/logs/',
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
    ),
    'session' => array(
        'sessionPrefix' => 'phalconbegins',
    ),
    'cookies' => array(
        'cryptKey' => '$#19AdB+?gHk(_pI',// 16, 24, 32 characters
        'prefix' => 'phalconbegins_',
    ),
    'security' => array(
        // A higher work factor will make the password less vulnerable as its encryption will be slow.
        'hashFactor' => 20,
    )
));

unset($auto_base_uri);
return $config_object;