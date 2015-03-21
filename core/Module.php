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

        //Registering a dispatcher
        $di->set('dispatcher', function() use($di) {
            // @todo find out how to use main services.php
            $evManager = $di->getShared('eventsManager');

            $evManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            array(
                                'module' => 'core',
                                'controller' => 'error',
                                'action' => 'e404',
                            )
                        );
                        return false;
                }
            });
            
            $dispatcher = new Dispatcher();
            
            // @todo find out how to use main services.php
            $dispatcher->setEventsManager($evManager);
            
            $dispatcher->setDefaultNamespace("Core\\Controllers");
            return $dispatcher;
        });

        //Registering the view component
        $di->set('view', function() use ($config) {
            $view = new View();
            $view->setViewsDir(__DIR__.'/views/');
            $view->registerEngines(array(
                '.volt' => function ($view, $di) use ($config) {

                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

                    $volt->setOptions(array(
                        'compiledPath' => $config->application->cacheDir,
                        'compiledSeparator' => '_'
                    ));

                    return $volt;
                },
                '.phtml' => '\\Phalcon\\Mvc\\View\\Engine\\Php',
                '.php' => '\\Phalcon\\Mvc\\View\\Engine\\Php',
            ));
            return $view;
        });
        
        $di['db'] = function() use ($config) {
            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->name
            ));
        };
    }


}