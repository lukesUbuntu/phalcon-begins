<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Extend;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\View\Engine\Volt;

/**
 * Modules trait.<br><br>
 * Use this file to manage register services in one place.<br>
 * To use this trait, set your module like Phalcon Module.php but extend \Extend\ModulesAbstract<br>
 * Setup $controller_namespace property for Module class to your default controller namespace<br>
 * Set $module_full_path property to __DIR__ for easy to manage.<br>
 */
trait ModulesTrait
{


    protected $default_controller_namespace = 'Core\\Controllers';
    protected $default_module_full_path = APPFULLPATH;


    /**
     * Register specific services for the module
     */
    public function registerServices($di)
    {
        // get module caller class to retrieve data-----------
        $module_caller_name = get_called_class();
        $module_caller = new $module_caller_name;
        if (property_exists($module_caller, 'controller_namespace')) {
            $default_namespace = $module_caller->controller_namespace;
        } else {
            $default_namespace = $this->default_controller_namespace;
        }
        if (property_exists($module_caller, 'module_full_path')) {
            $module_full_path = $module_caller->module_full_path;
        } else {
            $module_full_path = $this->default_module_full_path;
        }
        unset($module_caller_name);
        // end get module caller class ---------------------------
        
        $config = include APPFULLPATH.'/config/config.php';
        
        // Registering a dispatcher
        $di->set('dispatcher', function() use ($di, $default_namespace) {
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
            $dispatcher->setDefaultNamespace($default_namespace);
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function() use ($config, $module_full_path) {
            $view = new View();
            $view->setViewsDir($module_full_path.'/views/');
            if ($module_full_path != $this->default_module_full_path) {
                $view->setMainView('../../../core/views/index');
            }
            $view->registerEngines(array(
                '.volt' => function ($view, $di) use ($config) {

                    $volt = new Volt($view, $di);
                    
                    if (!file_exists($config->application->cacheDir.'volt/')) {
                        mkdir($config->application->cacheDir.'volt/');
                    }

                    $volt->setOptions(array(
                        'compiledPath' => $config->application->cacheDir.'volt/',
                        'compiledSeparator' => '_'
                    ));

                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
                '.php' => 'Phalcon\Mvc\View\Engine\Php',
            ));
            return $view;
        });
        
        unset($default_namespace, $module_full_path);
    }// registerServices


}