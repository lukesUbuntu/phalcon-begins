<?php
/* 
 * 
 *  @author Vee W.
 *  @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Contact;

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

        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Modules\\Contact\\Controllers");
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
    }// registerServices


}