<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Extend\Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Dispatcher as PhDispatcher;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

// set config to use in dependency injector.
$di->set('config', $config_object);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * add router support.
 */
$di->set('router', function() {
    include __DIR__.'/router.php';
    return $router;
});

// set dispatcher
$di->set('dispatcher', function() use ($di) {
    $evManager = $di->getShared('eventsManager');

    $evManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {
        switch ($exception->getCode()) {
            case PhDispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case PhDispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward(
                    array(
                        'namespace' => 'Core\\Controllers',
                        'module' => 'core',
                        'controller' => 'error',
                        'action' => 'e404',
                    )
                );
                return false;
        }
    }, true);
    
    $dispatcher = new PhDispatcher();
    $dispatcher->setEventsManager($evManager);
    //$dispatcher->setDefaultNamespace('Core\\Controllers');
    return $dispatcher;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        '.php' => 'Phalcon\Mvc\View\Engine\Php',
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'charset' => $config->database->charset
    ));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
