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
    'name'          => 'XIAOBAI_WIN7_X86_V123.iso',  //要分享的文件名
    'storage'       => '', //存放文件的目录名,文件存于??盘根目录
    'size'          => 12345315, //文件尺寸 ??Byte
    'hash'          => 'adsfasdf32dsafsffaasdfs23af', //文件md5哈希值, 文件Hash和Size都不对的情况下, 表明文件损坏
    'uploadSpeed'   => 15*1024,  //上传速度控制 ??Byte
    'downloadSpeed' => 100,      //下载速度控制 ??%  (目前无效)
    'downloadUrl'   => 'http://xxxx.com/dddd.asdfa.iso', //原始下载地址
];
//------------------//
$cf['files'][] = [
    'name'          => 'XIAOBAI_WIN7_X64_V123.iso',
    'storage'       => '', //存放文件的目录名,文件存于??盘根目录
    'size'          => 1234523424,
    'hash'          => 'adsfasdf32dsafsffaasdfs23af', //文件md5哈希值
    'uploadSpeed'   => 15*1024,
    'downloadSpeed' => 100,
    'downloadUrl'   => 'http://xxxx.com/dddd.asdfa.iso', //原始下载地址
];
//------------------//
$cf['files'][] = [
    'name'          => 'XIAOBAI_WIN8.1_X64_V456.iso',
    'storage'       => '', //存放文件的目录名,文件存于??盘根目录
    'size'          => 1234523424,
    'hash'          => 'adsfasdf32dsafsffaasdfs23af', //文件md5哈希值
    'uploadSpeed'   => 15*1024,
    'downloadSpeed' => 100,
    'downloadUrl'   => 'http://xxxx.com/dddd.asdfa.iso', //原始下载地址
];
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
