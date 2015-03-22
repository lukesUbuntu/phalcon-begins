<?php

// @todo [phalconbegins] register modules here.
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
        )
    )
);
// end register modules --------------------------------------------------------------------