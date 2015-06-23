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
    'fileName'      => 'GHOSTxp_MFZ_2015006ca1.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 1054672423,
    'fileHash'      => 'bc9ae2069a9bc43cd9b80b1a5431f5ce',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/xp/GHOSTxp_MFZ_2015006ca1.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/GHOSTxp_MFZ_2015006ca1.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'GHOSTxp_MFZ_201500422.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 1238929385,
    'fileHash'      => 'b32f1f36d5d6f905af9a4617bc7a2672',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/xp/GHOSTxp_MFZ_201500422.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/GHOSTxp_MFZ_201500422.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'GHOSTxp_MFZ_20150x07ca.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 1191047168,
    'fileHash'      => '7031fdcd302fc45a03fd7c727654a173',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/xp/GHOSTxp_MFZ_20150x07ca.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/GHOSTxp_MFZ_20150x07ca.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0525_ok.ORM',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4181151079,
    'fileHash'      => '6dba69518984d5127fd7b1942600c98f',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0525_ok.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_MFZ_0525_ok.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0521.ORM',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3962523031,
    'fileHash'      => 'b3cf97a7717064d39b134195bb2af30e',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0521.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_MFZ_0521.ORM.td.cfg',
];
//------------------//


$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0525_ok.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4182892369,
    'fileHash'      => '0663230d461d365f79114e50c674b946',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0525_ok.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_MFZ_0525_ok.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0525_ok.ISO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4318781440,
    'fileHash'      => '2db461d8a79dd7514c0aa9ca93351360',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0525_ok.ISO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_MFZ_0525_ok.ISO.td.cfg',
];
//------------------//


$cf['files'][] = [
    'fileName'      => 'win8.1_x64_MFZ_0521.gho',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4094053712,
    'fileHash'      => 'a5ea6f5cf18f920083f22a5ca0171543',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8.1_x64_MFZ_0521.gho',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_MFZ_0521.gho.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8_000b05mf.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3987504728,
    'fileHash'      => 'e9c6c4494e1c231404d3c0c83c9f24d8',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win8/win8_000b05mf.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8_000b05mf.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x64_MFZ_2015_0427.ORM',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3760669464,
    'fileHash'      => '910775fc1a6b5900e2c69d9717d68c1b',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x64_MFZ_2015_0427.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x64_MFZ_2015_0427.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x86_MFZ_2015_0427.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3145174914,
    'fileHash'      => 'de8c48fe1bcaaa7bfbc6d30108d08b08',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x86_MFZ_2015_0427.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x86_MFZ_2015_0427.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x64_MFZ_2015b0701ad.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4206891008,
    'fileHash'      => 'd91de70421cd46a478a7dc221220c607',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x64_MFZ_2015b0701ad.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x64_MFZ_2015b0701ad.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x86_MFZ_2015b0601ad.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3066473878,
    'fileHash'      => 'ab75c7c209b66a73e822505c9351403b',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x86_MFZ_2015b0601ad.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x86_MFZ_2015b0601ad.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x64_MFZ_2015_0427.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3975407457,
    'fileHash'      => '32646594c2d51f62c43e212951caeac9',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x64_MFZ_2015_0427.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x64_MFZ_2015_0427.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x86_MFZ_2015b0701ad.iso',
    'storage'       => 'MFZGhost',
    'fileSize'      => 3201595392,
    'fileHash'      => '2a02517e301943977636fc47c8f41f75',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x86_MFZ_2015b0701ad.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x86_MFZ_2015b0701ad.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'Win7_x64_MFZ_2015b0601ad.GHO',
    'storage'       => 'MFZGhost',
    'fileSize'      => 4070536119,
    'fileHash'      => '2d63c037960154f76cceb63c00a139c7',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.mofazhu.com/mofazhu/win7/Win7_x64_MFZ_2015b0601ad.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/Win7_x64_MFZ_2015b0601ad.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xiaobai_winXPxb06c1.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 1054159298,
    'fileHash'      => 'b88b8e4bbb34655a7663760d529d00f4',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/xp/xiaobai_winXPxb06c1.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xiaobai_winXPxb06c1.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xiaobai_winXP150421.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 1239036258,
    'fileHash'      => '61105f68cb6721fa6dab5fdd955e04c6',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/xp/xiaobai_winXP150421.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xiaobai_winXP150421.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8_1XB00501.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 3987819538,
    'fileHash'      => 'b680aa6043f74fdcc25580271ab7e743',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win8_1XB00501.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8_1XB00501.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win.8.1_x64_xiaobai_CZ_1506.ORM',
    'storage'       => 'XBGhost',
    'fileSize'      => 4181198527,
    'fileHash'      => '2da522528adff73a9d4f506235cadf33',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win.8.1_x64_xiaobai_CZ_1506.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win.8.1_x64_xiaobai_CZ_1506.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win.8.1_x64_xiaobai_CZ_1506.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 4183098646,
    'fileHash'      => '052d4cf5f37825330eb910cd535b135b',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win.8.1_x64_xiaobai_CZ_1506.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xxx.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_xiaobai_0525_ok.ORM',
    'storage'       => 'XBGhost',
    'fileSize'      => 4181198527,
    'fileHash'      => '2da522528adff73a9d4f506235cadf33',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win8.1_x64_xiaobai_0525_ok.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_xiaobai_0525_ok.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x64_xiaobai_0525_ok.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 4183098646,
    'fileHash'      => '052d4cf5f37825330eb910cd535b135b',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win8.1_x64_xiaobai_0525_ok.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x64_xiaobai_0525_ok.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win8.1_x32_xiaobai_0526_ok.gho',
    'storage'       => 'XBGhost',
    'fileSize'      => 3326930207,
    'fileHash'      => '5af83f615c7cad3a0a07fe47b19d6c77',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win8/win8.1_x32_xiaobai_0526_ok.gho',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win8.1_x32_xiaobai_0526_ok.gho.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xiaobai_baidu_64_2015_0423.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 3976359407,
    'fileHash'      => '40f2e139ce45e01d0b74f55dd13d9bef',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win7/xiaobai_baidu_64_2015_0423.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xiaobai_baidu_64_2015_0423.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xiaobai_bd_win764_2015_bc06a2.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 4069946043,
    'fileHash'      => '6eec56fb3fb075fb99dd4ceb22dada8c',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win7/xiaobai_bd_win764_2015_bc06a2.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xiaobai_bd_win764_2015_bc06a2.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xiaobai_bd_win786_2015_bc06a2.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 3066106620,
    'fileHash'      => '0b5df6216bfb654dd274d93e066bf75a',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win7/xiaobai_bd_win786_2015_bc06a2.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xiaobai_bd_win786_2015_bc06a2.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'XBwin7_x86_1504025.GHO',
    'storage'       => 'XBGhost',
    'fileSize'      => 3145956277,
    'fileHash'      => '9fc63a02937ccdfcfd980aba80c91d00',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.xiaobaixitong.com/xiaobai/win7/XBwin7_x86_1504025.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/XBwin7_x86_1504025.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'xtzj_WINxp_BC0601.GHO',
    'storage'       => 'ZJGhost',
    'fileSize'      => 1054758152,
    'fileHash'      => '8c78dd1f4f235bb6d4318ece0708f649',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/xp/xtzj_WINxp_BC0601.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/xtzj_WINxp_BC0601.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_32_CJ06.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3158290432,
    'fileHash'      => '0b6c676c798910d6b5275632db492ca3',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win832/SD_windowszj_8.1_32_CJ06.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/SD_windowszj_8.1_32_CJ06.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win7_ZJ_x64_CZ2015b060B2.GHO',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3826428044,
    'fileHash'      => '21f759f18dc5dea2505c099d414f4f4f',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win764/win7_ZJ_x64_CZ2015b060B2.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win7_ZJ_x64_CZ2015b060B2.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_64_CJ06.iso.ORM',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3737647606,
    'fileHash'      => 'ce748ec1546826356eadd48c06b92431',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/SD_windowszj_8.1_64_CJ06.iso.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/SD_windowszj_8.1_64_CJ06.iso.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'WIN8.1_X64_ZJ_CJ_0531_OK.ORM',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3737647606,
    'fileHash'      => 'ce748ec1546826356eadd48c06b92431',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/WIN8.1_X64_ZJ_CJ_0531_OK.ORM',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/WIN8.1_X64_ZJ_CJ_0531_OK.ORM.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_64_CJ06.iso.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3994546176,
    'fileHash'      => 'd8182bb312a45b9c80dc7946883a3725',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/SD_windowszj_8.1_64_CJ06.iso.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/SD_windowszj_8.1_64_CJ06.iso.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_windowszj_8.1_64_CJ06.iso.GHO',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3812825896,
    'fileHash'      => '3809a879eb04462aa2224ce547d7aac2',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/SD_windowszj_8.1_64_CJ06.iso.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/SD_windowszj_8.1_64_CJ06.iso.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'WIN8.1_X64_ZJ_CJ_0531_OK.GHO',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3812825896,
    'fileHash'      => '3809a879eb04462aa2224ce547d7aac2',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win864/WIN8.1_X64_ZJ_CJ_0531_OK.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/WIN8.1_X64_ZJ_CJ_0531_OK.GHO.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso',
    'storage'       => 'ZJGhost',
    'fileSize'      => 3079409664,
    'fileHash'      => '6a0a0801b56a4fe9a425a13e7b7ac94e',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win732/SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/SD_win786Ghost_CJ_SP1_2015_b0061ad4.iso.td.cfg',
];
//------------------//

$cf['files'][] = [
    'fileName'      => 'win732/win7_ZJ_x86_CZ2015b060B2.GHO',
    'storage'       => 'ZJGhost',
    'fileSize'      => 2923105646,
    'fileHash'      => '8530a45830b815d064e3f4dcd8ea6a1c',
    'uploadSpeed'   => 15,
    'downloadUrl'   => 'http://down.windowszj.com/zj/win732/win7_ZJ_x86_CZ2015b060B2.GHO',
    'tdConfigUrl'   => 'http://ctr.datacld.com/fs/xbspeed/win7_ZJ_x86_CZ2015b060B2.GHO.td.cfg',
];
//------------------//
//------------------//


/**勿动**/
return $cf;
/**勿动**/
