<?php
//*--------------------------------------------------------*/
// XBSpeed 服务控制配置
//*--------------------------------------------------------*/
$cf = ["files"=>[]];
$cf['version'] = '20150630';

//*--------------------------------------------------------*/
// 配置项
//*--------------------------------------------------------*/
$cf['files'][] = [
    'service'         => 'xbCoreDrv',     //服务名称
    'updateMode'      => 'install',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'LastVersion'     => '1.0.0',         // 最新版本的版本号
    'LastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'ReleaseTime'     => '2015/06/20',    // 最新版本发布时间
    'LowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'Arch'            => '32',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'FileName'        => 'xbCoreDrv.sys', //文件真实名称
    'FileSize'        => 6553556,          //文件大小 Byte
    'FileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'Download'        => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbcoredrv.upkg',//文件下载地址
];
//------------------//
$cf['files'][] = [
    'service'         => 'xbCoreCtr',     //服务名称
    'updateMode'      => 'install',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'LastVersion'     => '1.0.0',         // 最新版本的版本号
    'LastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'ReleaseTime'     => '2015/06/20',    // 最新版本发布时间
    'LowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'Arch'            => '32+64',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'FileName'        => 'xbCoreCtr.dll', //文件真实名称
    'FileSize'        => 65153556,          //文件大小 Byte
    'FileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'Download'        => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbcorectr.upkg',//文件下载地址
];
//------------------//
$cf['files'][] = [
    'service'         => 'xbSpeed',     //服务名称
    'updateMode'      => 'install',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'LastVersion'     => '1.0.0',         // 最新版本的版本号
    'LastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'ReleaseTime'     => '2015/06/20',    // 最新版本发布时间
    'LowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'Arch'            => '32+64',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'FileName'        => 'xbSpeed.exe',   //文件真实名称
    'FileSize'        => 46553556,          //文件大小 Byte
    'FileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'Download'        => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbSpeed.upkg',//文件下载地址
];
//------------------//
$cf['files'][] = [
    'service'         => 'xbKiller',     //服务名称
    'updateMode'      => 'uninstall',       //当为install时表示要安装或更新到这个版本, 当为uninstall时, 表示这个包, 要执行自我消除
    'LastVersion'     => '1.0.0',         // 最新版本的版本号
    'LastVersionCode' => 20150630,        //最新版本的版本代码,更新主要以这个Int号为准
    'ReleaseTime'     => '2015/06/20',    // 最新版本发布时间
    'LowCompatible'   => '5.1',           // (5.1) 最低兼容版本, 比如只兼容到win7, xp系统来更新, 将不会执行更新
    'Arch'            => '32',         //[32|64|32+64] 标识系统架构, 32+64表示都支持,其他表示指定
    'FileName'        => 'xbKiller.exe', //文件真实名称
    'FileSize'        => 65532556,          //文件大小 Byte
    'FileHash'        => '8679374d1a8ccfd7f89c37d2e69f9ea5',  //文件MD5摘要
    'Download'        => 'http://ctr.datacld.com/release/'.$cf['version'].'/xbKiller.upkg',//文件下载地址
];
//------------------//
//------------------//
//------------------//
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
