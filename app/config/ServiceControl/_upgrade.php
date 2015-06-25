<?php
//*--------------------------------------------------------*/
// XBSpeed 服务控制配置
//*--------------------------------------------------------*/
$cf = ["files"=>[]];
$cf['version'] = 20150625;

//*--------------------------------------------------------*/
// 配置项
//*--------------------------------------------------------*/
$cf['files'][] = [
    'service'         => 'xbCoreDrv',     //服务名称
    'updateMode'      => 'install',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'lastVersion'     => '1.0.0',         // 最新版本的版本号
    'lastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'releaseTime'     => '2015/06/20',    // 最新版本发布时间
    'lowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'arch'            => '32',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'fileName'        => 'xbCoreDrv.sys', //文件真实名称
    'fileSize'        => 6553556,          //文件大小 Byte
    'fileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'downloadUrl'        => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbcoredrv.upkg',//文件下载地址
];
//------------------//
$cf['files'][] = [
    'service'         => 'xbCoreCtr',     //服务名称
    'updateMode'      => 'install',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'lastVersion'     => '1.0.0',         // 最新版本的版本号
    'lastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'releaseTime'     => '2015/06/20',    // 最新版本发布时间
    'lowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'arch'            => '32+64',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'fileName'        => 'xbCoreCtr.dll', //文件真实名称
    'fileSize'        => 65153556,          //文件大小 Byte
    'fileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'downloadUrl'     => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbcorectr.upkg',//文件下载地址
];
//------------------//
$cf['files'][] = [
'service'         => 'xbSpeed',
'updateMode'      => 'install',
'lastVersion'     => '1.0.0',
'lastVersionCode' => 20150625,
'releaseTime'     => '2015/06/25',
'lowCompatible'   => '5.1',
'arch'            => '32+64',
'fileName'        => 'xbSpeed.exe',
'fileSize'        => 494736,
'fileHash'        => 'a10343c91c07ea05a9f18656a6932c3e',
'downloadUrl'     => 'http://ctr.datacld.com/fs/svc/xbspeed/upgrade/20150625.upkg',
];
//------------------//
$cf['files'][] = [
    'service'         => 'xbKiller',     //服务名称
    'updateMode'      => 'uninstall',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'lastVersion'     => '1.0.0',         // 最新版本的版本号
    'lastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'releaseTime'     => '2015/06/20',    // 最新版本发布时间
    'lowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'arch'            => '32',           //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'fileName'        => 'xbKiller.exe', //文件真实名称
    'fileSize'        => 65532556,          //文件大小 Byte
    'fileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'downloadUrl'     => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbKiller.upkg',//文件下载地址
];
//------------------//
//------------------//
//------------------//
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
