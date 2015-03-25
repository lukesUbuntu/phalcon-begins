<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

namespace Modules\Dbt;

use Phalcon\Loader;

class Module extends \Extend\ModulesAbstract
{


    protected $controller_namespace = 'Modules\\Dbt\\Controllers';
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
                'Modules\\Dbt\\Models'      => __DIR__.'/models/',
                'Modules\\Dbt\\Forms' => __DIR__.'/forms',
                'Core\\Controllers' => APPFULLPATH.'/controllers/',
            )
        );

        $loader->register();
    }// registerAutoloaders


}