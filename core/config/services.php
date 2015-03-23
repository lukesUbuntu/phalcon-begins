<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Extend\Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
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

/**
 * For more services that want to register, please use /core/Extend/ModulesTrait.php instead.
 */

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

// Start the session the first time some component request the session service
$di->set('session', function () use ($config) {
    $session = new \Phalcon\Session\Adapter\Files(
        array(
            'uniqueId' => $config->session->sessionPrefix
        )
    );
    $session->start();

    return $session;
});

// start cookies
$di->set('cookies', function() {
    $cookies = new Extend\Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;
});

// set crypt key. this key also use with cookies.
$di->set('crypt', function() use ($config) {
    $crypt = new \Phalcon\Crypt();
    $crypt->setKey($config->cookies->cryptKey);
    return $crypt;
});
