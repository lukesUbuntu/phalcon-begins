<?php

error_reporting(E_ALL);

// setup constants
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOTFULLPATH')) {
    define('ROOTFULLPATH', __DIR__);// if this file is under /public, up one level.
}
if (!defined('APPFULLPATH')) {
    define('APPFULLPATH', ROOTFULLPATH.DS.'core');
}
if (!defined('MODULEFULLPATH')) {
    define('MODULEFULLPATH', ROOTFULLPATH.DS.'modules');
}

try {

    /**
     * Read the configuration
     */
    $config = include APPFULLPATH . '/config/config.php';

    /**
     * Read auto-loader
     */
    include APPFULLPATH . '/config/loader.php';

    /**
     * Read services
     */
    include APPFULLPATH . '/config/services.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);
    
    // @todo [phalconbegins] register modules here.
    // register modules -------------------------------------------------------------------------
    $application->registerModules(
        array(
            'core' => array(
                'className' => 'Core\\Module',
                'path' => APPFULLPATH . '/Module.php',
            ),
            'contact' => array(
                'className' => 'Modules\\Contact\\Module',
                'path' => ROOTFULLPATH . '/modules/contact/Module.php',
            )
        )
    );
    // end register modules --------------------------------------------------------------------

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
