<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->extendDir,
    )
)->register();

/**
 * register namespaces
 */
$loader->registerNamespaces(
    array(
        'Libraries' => $config->application->libraryDir,
        'Extend' => $config->application->extendDir,
    )
)->register();
