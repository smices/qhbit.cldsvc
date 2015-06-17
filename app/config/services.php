<?php
use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\View\Engine\Volt as VoltEngine,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    Phalcon\Crypt as Crypt,
    Phalcon\Http\Response\Cookies as Cookies;

$di = new FactoryDefault();
/*
if($GLOBALS['__DYRUNMODE__'] == 'development' || $GLOBALS['__DYRUNMODE__'] == 'testing'){
    //Load Debug Widget
    $namespaces = array_merge($loader->getNamespaces(), array('PDW'=>$config->application->pluginsDir));
    $loader->registerNamespaces($namespaces);
    $debugWidget = new \PDW\DebugWidget($di);
}*/


$di->set('url', function() use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

$di->set('view', function() use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.phtml'  => 'Phalcon\Mvc\View\Engine\Php'
    ));
    return $view;
}, true);

$di->setShared('dispatcher', function() {
    $eventsManager = new Phalcon\Events\Manager();
    $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) {
        //The controller exists but the action not
        if ($event->getType() == 'beforeNotFoundAction') {
            $dispatcher->forward(array(
                'controller' => 'error',
                'action' => 'e404'
            ));
            return false;
        }

        //Alternative way, controller or action doesn't exist
        if ($event->getType() == 'beforeException') {
            switch ($exception->getCode()) {
                case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action' => 'e404'
                    ));
                    return false;
            }
        }
    });
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    //Bind the EventsManager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

/**
 * member MySQL
 */
$di->set('db', function() use ($config) {
    $db = new DbAdapter(array(
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname
    ));
    $db->query("SET NAMES UTF8");
    return $db;
});

$di->set('modelsMetadata', function() {
    return new MetaDataAdapter();
});

$di->set('session', function() {
    $session = new Phalcon\Session\Adapter\Files();
    if($session->isStarted() == FALSE){
        $session->start();
    }
    return $session;
});


/**
 * member MongoDB
 */
/*
$di->set('mongo', function() {
    $mongo = new Mongo("mongodb://root:powerauyccom@127.0.0.1:27017");
    return $mongo->selectDB("admin");
}, true);
*/

/**
 * member the flash service with custom CSS classes
 */
$di->set('flash', function(){
    $flash = new \Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-error text-center',
        'success' => 'alert alert-success text-center',
        'notice'  => 'alert alert-info text-center',
    ));
    return $flash;
});


/**
 * member the logger
 */
$di->set('logger', function () use ($config) {
    if ('database' == strtolower($config->logger->adapter)) {
        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->logger->host,
            "username" => $config->logger->username,
            "password" => $config->logger->password,
            "dbname" => $config->logger->name
        ));
        $logger = new Phalcon\Logger\Adapter\Database('errors', array(
            'db' => $connection,
            'table' => $config->logger->table
        ));
        //$logger->info("initialize database logger successfully.");
    } else {

        $logger = new \Phalcon\Logger\Adapter\File($config->logger->path . date("Ymd") . '.log',
            array('mode' => 'a'));
        //$logger->info("initialize file logger successfully.");
    }

    return $logger;
});

/**
 * member the crypt
 */
$di->set('crypt', function() {
    $crypt = new Crypt();
    $crypt->setKey("SZDYKJYXGS2DIYEGROUPOFCHINA");
    return $crypt;
});

/**
 * member the cookie
 */
$di->set('cookies', function() {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;
});
