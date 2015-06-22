<?php
//*--------------------------------------------------------*/
// XBSpeed 服务控制配置
//*--------------------------------------------------------*/
$cf = ["files"=>[]];
$cf['version'] = 20150621;

//*--------------------------------------------------------*/
// 配置项
//*--------------------------------------------------------*/
$cf['files'][] = [
    'name'              => '小白管家',                 //应用名称
    'package'           => 'xiaobai_v1.0.0.exe',      //安装包名称,需要重设的话, 请修改本项
    'fileSize'          => 6553556,          //文件大小 Byte
    'hash'              => 'andjftufosdifjgut341jfjfhfhfureirjf', //文件Hash
    'platform'          => '6.1',         //主要针对平台
    'lowCompatible'     => '5.0',         //最低兼容版本
    'lastVersion'       => '1.0.0',       //程序版本号
    'lastVersionCode'   => 12345315,      //整数版本号
    'releaseTime'       => '2015/5/23',   //文件版本发布时间
    'description'       => '更新内容',      //更新内容
    'fetchUrl'          => 'http://hao.360.cn/abc.exe', //原始下载地址
];
//------------------//
$cf['files'][] = [
    'name'              => '360管家',                 //应用名称
    'package'           => '360_v1.0.0.exe',      //安装包名称,需要重设的话, 请修改本项
    'fileSize'          => 6553556,          //文件大小 Byte
    'hash'              => 'andjftufosdifjgut341jfjfhfhfureirjf', //文件Hash
    'platform'          => '6.1',         //主要针对平台
    'lowCompatible'     => '5.0',         //最低兼容版本
    'lastVersion'       => '1.0.0',       //程序版本号
    'lastVersionCode'   => 12345315,      //整数版本号
    'releaseTime'       => '2015/5/23',   //文件版本发布时间
    'description'       => '更新内容',      //更新内容
    'fetchUrl'          => 'http://hao.360.cn/abc.exe', //原始下载地址
];
//------------------//
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
