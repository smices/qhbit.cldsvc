<?php
use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Crypt as Crypt,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as BackFile,
    Phalcon\Cache\Backend\Memcache as MemcacheCache;

/**********************************************************************
 * BASE SETTINGS
 **********************************************************************/
$config = require realpath("../app/config/config." . $GLOBALS['__DYRUNMODE__'] . ".php");

define("_DYP_APPVER_JOURNAL", "1.1.2.15729");
define("_DYP_APPVER_REVISE", "01");
define("_DYP_APPVER_NAME", "DYXB");
define("_DYP_APPVER", _DYP_APPVER_JOURNAL . '.' . _DYP_APPVER_REVISE);



/**********************************************************************
 * Loader Configuration
 **********************************************************************/
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    'modelsDir'        => $config->application->modelsDir,
    'controllersDir'   => $config->application->controllersDir,
//    'DYPA'             => _DYP_DIR_APP,
    'DYPA\Controllers' => $config->application->controllersDir,
    'DYPA\Models'      => $config->application->modelsDir,
    'DYP'              => $config->application->libraryDir . '/DYP/'
//    'Phalcon'          => $config->application->libraryDir . '/Phalcon/',
));

$loader->registerDirs(array(
    $config->application->controllersDir,
    $config->application->modelsDir,
    $config->application->libraryDir,
    $config->application->pluginsDir
))->register();


/**********************************************************************
 * Services Configuration
 **********************************************************************/
$di = new FactoryDefault();

/**
 * Router Configuration
 */
$di->set('router', function () {return require __DIR__ . '/router.php';}, true);

/**
 * Url Resolver Configuration
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

/**
 * View Configuration
 */
$di->set('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));
    return $view;
}, true);

/**
 * member MySQL
 */
$di->set('db', function () use ($config) {
    $db = new DbAdapter(array(
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname
    ));
    $db->query("SET NAMES UTF8");

    return $db;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
    return new MetaDataAdapter();
});

/**
 * Session
 */
$di->set('session', function () {
    $session = new \Phalcon\Session\Adapter\Memcache(array(
        'uniqueId'   => 'ctr.datacld',
        'host'       => '127.0.0.1',
        'port'       => 11211,
        'persistent' => true,
        'lifetime'   => 3600,
        'prefix'     => 'sess_'
    ));
    /*
    $session = new Phalcon\Session\Adapter\Files();
    if($session->isStarted() == FALSE){
        $session->start();
    }
    */
    return $session;
});

/**
 * The flash service with custom CSS classes
 */
$di->set('flash', function () {
    $flash = new \Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-error text-center',
        'success' => 'alert alert-success text-center',
        'notice'  => 'alert alert-info text-center',
    ));
    return $flash;
});

/**
 * member the crypt
 */
$di->set('crypt', function () {
    $crypt = new Crypt();
    $crypt->setKey("4069f89ee64ea5b1dcd22783cd032a46");
    return $crypt;
});

/**
 * member the cookie
 */
$di->set('cookies', function () {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(true);
    return $cookies;
});

/**
 * Data Cache By Memory
 */
$di->set('memCache', function () {
    //Cache data for 2 day
    $frontCache = new FrontData(array("lifetime" => 172800));
    /**
     * Create the component that will cache "Data" to a "Memcached" backend
     * Memcached connection settings
     */
    $cache = new MemcacheCache($frontCache, array(
        "servers" => array(
            array(
                "host"   => "127.0.0.1",
                "port"   => "11211",
                "weight" => "1"
            )
        )
    ));

    return $cache;
});

/**
 * Data Cache By Files
 */
$di->set('fileCache', function () use ($config) {
    // Cache the files for 2000 days using a Data frontend
    $frontCache = new FrontData(array("lifetime" => 172800000));
    /**
     * Create the component that will cache "Data" to a "File" backend
     * Set the cache file directory - important to keep the "/" at the end of
     * of the value for the folder
     */
    $cache = new BackFile($frontCache, array(
        "cacheDir" => $config->application->cacheDir
    ));

    return $cache;
});

/**
 * Dispatcher Configuration
 */
$di->setShared('dispatcher', function () {
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace('DYPA\Controllers');

    return $dispatcher;
});



/**********************************************************************
 * Bootstrap
 **********************************************************************/
try {
    $application = new Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    $msg = "Exception:" . PHP_EOL;
    $msg .= 'FILE:' . str_replace(_DYP_DIR_ROOT, '', $e->getFile()) . PHP_EOL;
    $msg .= 'LINE:' . $e->getLine() . PHP_EOL;
    $msg .= 'MESSAGE:' . $e->getMessage() . PHP_EOL;
    d($e);
    d(get_required_files());
    die(nl2br($msg));
}
