<?php
use Phalcon\Mvc\Router;

$router = new Phalcon\Mvc\Router(false);

$router->add('/', array(
    'namespace'  => 'DYPA\Controllers',
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
 * User Router Configuration
 ********************************************************************************/
$router->add('/user/:controller/:action/:params', array(
    'namespace'  => 'DYPA\Controllers\User',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
));

$router->add('/user/:controller', array(
    'namespace'  => 'DYPA\Controllers\User',
    'controller' => 1
));

$router->add('/user', array(
    'namespace'  => 'DYPA\Controllers\User',
    'controller' => 'index',
    'action'     => 'index',
));

/********************************************************************************
 * Public Service Router Configuration
 ********************************************************************************/
$router->add('/pubsvc/:controller/:action/:params', array(
    'namespace'  => 'DYPA\Controllers\Pubsvc',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
));

$router->add('/pubsvc/:controller', array(
    'namespace'  => 'DYPA\Controllers\Pubsvc',
    'controller' => 1
));

$router->add('/pubsvc', array(
    'namespace'  => 'DYPA\Controllers\Pubsvc',
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
