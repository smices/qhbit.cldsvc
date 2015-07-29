<?php
use Phalcon\Mvc\Router;

$router = new Phalcon\Mvc\Router(true);

// Setting a specific default
/*$router->setDefaultModule('DYPA\Models');
$router->setDefaultNamespace('DYPA');
$router->setDefaultController('index');
$router->setDefaultAction('index');*/


$router->add('', array(
    "namespace"  => 'DYPA\Controllers',
    'controller' => 'index',
    'action'     => 'index'
));

$router->add('/:controller/:action/:params', array(
    'namespace'  => 'DYPA\Controllers',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
));

$router->add('/:controller', array(
    'namespace'  => 'DYPA\Controllers',
    'controller' => 1
));

/********************************************************************************
 * Control Panel Router Configuration
 ********************************************************************************/
$router->add('/cp/:controller/:action/:params', array(
    'namespace'  => 'DYPA\Controllers\Cp',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
));

$router->add('/cp/:controller', array(
    'namespace'  => 'DYPA\Controllers\Cp',
    'controller' => 1
));

$router->add('/cp', array(
    'namespace'  => 'DYPA\Controllers\Cp',
    'controller' => 'index',
    'action'     => 'index',
));

/********************************************************************************
 * API Router Configuration
 ********************************************************************************/
$router->add('/api/:controller/:action/:params', array(
    'namespace'  => 'DYPA\Controllers\Api',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
));

$router->add('/api/:controller', array(
    'namespace'  => 'DYPA\Controllers\Api',
    'controller' => 1
));

$router->add('/api', array(
    'namespace'  => 'DYPA\Controllers\Api',
    'controller' => 'index',
    'action'     => 'index',
));

// Set 404 paths
$router->notFound(array(
    'namespace'  => 'DYPA\Controllers',
    "controller" => "error",
    "action"     => "e404"
));

return $router;
