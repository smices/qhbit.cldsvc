<?php
define("_DYP_APPVER_JOURNAL", "1.0.0.0");
define("_DYP_APPVER_REVISE", "20150729");
define("_DYP_APPVER_NAME", "DYXB");
define("_DYP_APPVER", _DYP_APPVER_JOURNAL . '.' . _DYP_APPVER_REVISE);

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    'modelsDir'        => $config->application->modelsDir,
    'controllersDir'   => $config->application->controllersDir,
    'DYPA\Controllers' => $config->application->controllersDir,
    'DYPA\Models'      => $config->application->modelsDir,
    'DYP'              => $config->application->libraryDir . '/DYP/'
    //'Phalcon'          => $config->application->libraryDir . '/Phalcon/',
));

$loader->registerDirs(array(
    $config->application->controllersDir,
    $config->application->modelsDir,
    $config->application->libraryDir,
    $config->application->pluginsDir
))->register();
