<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Core;

use Phalcon\Loader;

class Module extends \Extend\ModulesAbstract
{


    protected $controller_namespace = 'Core\\Controllers';
    protected $module_full_path = __DIR__;


    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                $this->controller_namespace => __DIR__.'/controllers/',
                'Core\\Models'      => __DIR__.'/models/',
            )
        );

        $loader->register();
    }// registerAutoloaders


}