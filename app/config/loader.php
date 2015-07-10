<?php
define("_DYP_APPVER_JOURNAL",  "0.01");
define("_DYP_APPVER_REVISE",   "01");
define("_DYP_APPVER_NAME",     "DYBBC");
define("_DYP_APPVER",          _DYP_APPVER_JOURNAL.'.'._DYP_APPVER_REVISE);

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    //'Phalcon' => $config->application->libraryDir . '/Phalcon/',
    'DYP'     => $config->application->libraryDir . '/DYP/'
));

$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->pluginsDir
    )
)->register();

