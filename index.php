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
    
    // register modules
    include APPFULLPATH . '/config/modules.php';

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    if (preg_match('/Module (.*) is not registered/ius', $e->getMessage()) == 1) {
        // catched module is not registered error!
        // @todo [phalconbegins][multi modules] find the way to use error controller.
        header('HTTP/1.0 404 Not Found');
        echo 'not found';
        exit;
    }
    
    // another error!
    echo get_class($e), ": ", $e->getMessage(), "<br>\n";
    echo " File=", $e->getFile(), "<br>\n";
    echo " Line=", $e->getLine(), "<br>\n";
    echo "<br>\n";
    echo nl2br($e->getTraceAsString());
}
