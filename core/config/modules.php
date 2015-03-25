<?php

// @todo [phalconbegins][multi modules] register modules here.
// register modules -------------------------------------------------------------------------
$application->registerModules(
    array(
        'core' => array(
            'className' => 'Core\\Module',
            'path' => APPFULLPATH . '/Module.php',
        ),
        'contact' => array(
            'className' => 'Modules\\Contact\\Module',
            'path' => ROOTFULLPATH . '/modules/contact/Module.php',
        ),
        'dbt' => array(
            'className' => 'Modules\\Dbt\\Module',
            'path' => ROOTFULLPATH . '/modules/dbt/Module.php',
        ),
    )
);
// end register modules --------------------------------------------------------------------