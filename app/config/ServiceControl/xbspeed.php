<?php
//*--------------------------------------------------------*/
// XBSpeed 服务控制配置
//*--------------------------------------------------------*/
$cf = ["files"=>[]];
$cf['version'] = 20150622;

//*--------------------------------------------------------*/
// 配置项
//*--------------------------------------------------------*/
/***** 实例说明
$cf['files'][] = [
    'fileName'      => 'SD_win764_Ghost_CJ_SP1_2015_b0061ad.iso.iso',  //要分享的文件名
    'storage'       => 'SDGHOST', //存放文件的目录名,文件存于??盘根目录
    'fileSize'      => 3984936960, //文件尺寸 ??Byte
    'fileHash'      => '74df9cb54b1d1a02918e6de9ee53736a', //文件md5哈希值, 文件Hash和Size都不对的情况下, 表明文件损坏
    'uploadSpeed'   => 15,  //上传速度控制 ??KByte
    'downloadUrl'   => 'http://7en.mofazhu.com:808/win764/SD/SD_win764_Ghost_CJ_SP1_2015_b0061ad.iso.iso', //原始下载地址
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/GHOSTxp_MFZ_2015006ca1.GHO.td.cfg', //构造的迅雷下载配置文件
];
********/

//------------------//

$cf['files'][] = [
    'fileName'      => 'GHOSTxp_MFZ_20150x07ca.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 1191047168,
    'fileHash'      => '7031fdcd302fc45a03fd7c727654a173',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/xp/GHOSTxp_MFZ_20150x07ca.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/GHOSTxp_MFZ_20150x07ca.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0525_ok.ISO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4318781440,
    'fileHash'      => '2db461d8a79dd7514c0aa9ca93351360',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0525_ok.ISO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/win8.1_x64_MFZ_0525_ok.ISO.td.cfg',
];
//------------------//


//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x64_MFZ_2015b0701ad.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4206891008,
    'fileHash'      => 'd91de70421cd46a478a7dc221220c607',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x64_MFZ_2015b0701ad.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/Win7_x64_MFZ_2015b0701ad.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x86_MFZ_2015b0701ad.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3201595392,
    'fileHash'      => '2a02517e301943977636fc47c8f41f75',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x86_MFZ_2015b0701ad.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/Win7_x86_MFZ_2015b0701ad.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_32_CJ06.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3158290432,
    'fileHash'      => '0b6c676c798910d6b5275632db492ca3',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win832/SD_windowszj_8.1_32_CJ06.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/SD_windowszj_8.1_32_CJ06.iso.td.cfg',
];
//------------------//

//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_64_CJ06.iso.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3994546176,
    'fileHash'      => 'd8182bb312a45b9c80dc7946883a3725',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/SD_windowszj_8.1_64_CJ06.iso.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/SD_windowszj_8.1_64_CJ06.iso.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3079409664,
    'fileHash'      => '6a0a0801b56a4fe9a425a13e7b7ac94e',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win732/SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso.td.cfg',
];
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
