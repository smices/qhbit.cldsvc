<?php
/**
 * 入口文件
 */
//基础配置
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');


//环境检测
if (is_file('../app/config/production')){putenv('DYRUNMODE=production');
}elseif (is_file('../app/config/testing')){putenv('DYRUNMODE=testing');
}elseif (is_file('../app/config/development')){putenv('DYRUNMODE=development');
}else{putenv('DYRUNMODE=production');}


//仅在Testing和Development模式下开启调试模式
$__DYRUNMODE__ = getenv('DYRUNMODE');
$GLOBALS['__DYRUNMODE__'] = $__DYRUNMODE__;




if($GLOBALS['__DYRUNMODE__'] == 'development' || $GLOBALS['__DYRUNMODE__'] == 'testing'){
    require realpath('../app/library/kint/Kint.class.php');

    function sizeFmt ($size){
        $unit=array('byte','K','M','G','T','P');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).$unit[$i];
    }
    function runTimerStop(){
        $consumeTime = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 1);
        return 'Env:' . $GLOBALS['__DYRUNMODE__'] .
        'Time-consuming:'.$consumeTime / 1000 . 's,'.$consumeTime.'ms,'.
        'Memory Use(emalloc,real,peak):'.sizeFmt(memory_get_usage()).
        ','.sizeFmt(memory_get_usage(true))
        .','.sizeFmt(memory_get_peak_usage())
        .'Version:'._DYP_APPVER_NAME .' '._DYP_APPVER.','
        .'Include Files:'.count(get_included_files());
    }
}

//开始处理业务代码
try {
    $config = require realpath("../app/config/config.".$GLOBALS['__DYRUNMODE__'].".php");
    require _DYP_DIR_CFG . DIR_SEP . 'loader.php';
    require _DYP_DIR_CFG . DIR_SEP . 'services.php';
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage();
}

//output debug info
if($GLOBALS['__DYRUNMODE__'] == 'development' || $GLOBALS['__DYRUNMODE__'] == 'testing'){
    echo '<script>console.log(\''.strip_tags(runTimerStop()).'\');</script>';
}
