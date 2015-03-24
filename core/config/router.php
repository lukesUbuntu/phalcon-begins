<?php
/* 
 * 
 * @author Vee W.
 * @license http://opensource.org/licenses/MIT
 * 
 */

$router = new Phalcon\Mvc\Router();

$router->removeExtraSlashes(true);

// required for modules.
$router->setDefaultModule('core');

/*$router->notFound(
    array(
        //'namespace' => 'Core\\Controllers',
        'module' => 'core',
        'controller' => 'error',
        'action' => 'e404',
    )
);*/

// please add router at the bottom. phalcon use latest routes added have more relevance than first!
// modules router ---------------------------------------------------------------
$router->add(
    '/{lang:[a-z]{2}}/:module/:controller/:action/:params',
    array(
        'module' => 2,
        'controller' => 3,
        'action' => 4,
        'params' => 5,
    )
);
$router->add(
    '/{lang:[a-z]{2}}/:module/:controller/:action',
    array(
        'module' => 2,
        'controller' => 3,
        'action' => 4,
    )
);
$router->add(
    '/{lang:[a-z]{2}}/:module/:controller',
    array(
        'module' => 2,
        'controller' => 3,
        'action' => 'index',
    )
);
$router->add(
    '/{lang:[a-z]{2}}/:module',
    array(
        'module' => 2,
        'controller' => 'index',
        'action' => 'index',
    )
);
// end modules router ----------------------------------------------------------

// the line below this should stay at the bottom. 
// @todo [phalconbegins][multi modules] add module router here. -------



// end add module router here. ------------------------------------------------

// the default module at url /{lang} or /index
$router->add(
    '/{lang:[a-z]{2}}/index/:action/:params',
    array(
        'module' => 'core',
        'controller' => 'index',
        'action' => 2,
        'params' => 3,
    )
);
$router->add(
    '/{lang:[a-z]{2}}', 
    array(
        'module' => 'core',
        'controller' => 'index',
        'action' => 'index',
    )
);