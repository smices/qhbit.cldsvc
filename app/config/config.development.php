<?php
define("DIR_SEP",              DIRECTORY_SEPARATOR);
define("_DYP_DIR_ROOT",        dirname(dirname(__DIR__)));

define("_DYP_DIR_APP",         realpath(_DYP_DIR_ROOT . "/app"));
define("_DYP_DIR_DYP",         realpath(_DYP_DIR_ROOT . "/app/DYP"));
define("_DYP_DIR_PUB",         realpath(_DYP_DIR_ROOT . "/public"));
define("_DYP_DIR_FS",          realpath(_DYP_DIR_ROOT . "/public/fs"));
define("_DYP_DIR_TMP",         realpath(_DYP_DIR_ROOT . "/tmp"));

define("_DYP_DIR_CFG",         realpath(_DYP_DIR_APP . "/config"));
define("_DYP_DIR_CRT",         realpath(_DYP_DIR_APP . "/controllers"));
define("_DYP_DIR_LIB",         realpath(_DYP_DIR_APP . "/library"));
define("_DYP_DIR_MODEL",       realpath(_DYP_DIR_APP . "/models"));
define("_DYP_DIR_PLUGIN",      realpath(_DYP_DIR_APP . "/plugins"));
define("_DYP_DIR_VIEW",        realpath(_DYP_DIR_APP . "/views"));

//图片服务器
define("_DYP_HOST_PIC",        "http://i.datacld.com");


return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'datacld.com:13366',
        'username'    => 'datacld',
        'password'    => 'powerdatacldcom',
        'dbname'      => 'datacld_ctr',
    ),

    'logger' => array(

        'adapter'  => 'file',
        'path'     => _DYP_DIR_TMP . '/log/',
    ),

    'application' => array(
        'controllersDir' => _DYP_DIR_CRT . DIR_SEP,
        'modelsDir'      => _DYP_DIR_MODEL . DIR_SEP,
        'viewsDir'       => _DYP_DIR_VIEW . DIR_SEP,
        'pluginsDir'     => _DYP_DIR_PLUGIN . DIR_SEP,
        'libraryDir'     => _DYP_DIR_LIB . DIR_SEP,
        'cacheDir'       => _DYP_DIR_TMP. DIR_SEP . 'cache' . DIR_SEP,
        'baseUri'        => '/',
    )
));
