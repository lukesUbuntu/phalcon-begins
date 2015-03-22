<?php
/* 
 * 
 *  @author Vee W.
 *  @license http://opensource.org/licenses/MIT
 * 
 */

namespace Core;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\View\Engine\Volt,
    Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{


    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Core\\Controllers' => __DIR__.'/controllers/',
                'Core\\Models'      => __DIR__.'/models/',
            )
        );

        $loader->register();
    }// registerAutoloaders


    /**
     * Register specific services for the module
     */
    public function registerServices($di)
    {
        $config = include APPFULLPATH.'/config/config.php';
        $dispatcher = $di->getShared('dispatcher');

        // Registering a dispatcher
        $di->set('dispatcher', function() use($di, $dispatcher) {
            $dispatcher->setDefaultNamespace("Core\\Controllers");
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function() use ($config) {
            $view = new View();
            $view->setViewsDir(__DIR__.'/views/');
            $view->registerEngines(array(
                '.volt' => function ($view, $di) use ($config) {

                    $volt = new Volt($view, $di);

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
        });
    }


}