<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * @todo [phalconbegins][multi modules] find the way to use common register services.
 * 
 */

namespace Modules\Contact;

use Phalcon\Loader;

class Module extends \Extend\ModulesAbstract
{


    protected $controller_namespace = 'Modules\\Contact\\Controllers';
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
                'Modules\\Contact\\Models'      => __DIR__.'/models/',
                'Core\\Controllers' => APPFULLPATH.'/controllers/',
            )
        );

        $loader->register();
    }// registerAutoloaders


}