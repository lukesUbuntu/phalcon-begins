<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * @todo [phalconbegins][multi modules] find the way to use common register services.
 * 
 */

namespace Modules\Contact;

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
                'Modules\\Contact\\Controllers' => __DIR__.'/controllers/',
                'Modules\\Contact\\Models'      => __DIR__.'/models/',
                'Core\\Controllers' => APPFULLPATH.'/controllers/',
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

        // Registering a dispatcher
        $di->set('dispatcher', function() use ($di) {
            $evManager = $di->getShared('eventsManager');

            $evManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
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
            $dispatcher = new Dispatcher;
            $dispatcher->setEventsManager($evManager);
            $dispatcher->setDefaultNamespace('Modules\\Contact\\Controllers');
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
    }// registerServices


}