<?php
class GenTask extends \Phalcon\CLI\Task
{
    public function mainAction() {
         echo "\nThis is the default task and the default action \n";
    }

    /**
    * @param array $params
    */
   public function upkgAction(array $params) {
	   var_dump($params);
		$opt = getopt("f:v:h:");
		var_dump($opt);
		$help="Help:\n".$params[0]." -f <*File> -v <Version> -h <Help>\n";
		if(empty($opt['f'])){ 
			echo $help."\n";exit(); 
		}

   }

}


/**

$opt = getopt("f:v:h:");
$help="Help:\n".$argv[0]." -f <*File> -v <Version> -h <Help>\n";
if(empty($opt['f'])){ 
	echo $help."\n";exit(); 
}

$_version_ = (!empty($opt['v']))? $opt['v'] : '1.0.0';

function consoleStr($str){
	if("WINNT" == PHP_OS || "WINDOWS" == PHP_OS){
		//system("CHCP 65001");
		$detectCharSet = mb_detect_encoding("中文");
		$ConsoleCharSet = "GB2312";
		$destStr = mb_convert_encoding($str, $ConsoleCharSet, $detectCharSet);
		return $destStr;
	}
	return $str;
}

function showError($msg, $exit=true){
	echo "ERROR:-----------------\n\n";
	echo consoleStr($msg);
	echo "\n\n-----------------:ERROR\n";
	exit(0);
}
function cmsg($msg){
	echo consoleStr($msg) . "\n";
}

function xbCompress($src, $dest){
	$fpr = fopen($src, "rb");
	$contents = fread($fpr, filesize ($src));
	fclose($fpr);

	$fpw = fopen($dest, "wb");
	fwrite($fpw, snappy_compress($contents));
	//fwrite($fpw, gzcompress($contents));
	fclose($fpw);
}//end

function xbUncompress($src, $dest){
	$fpr = fopen($src, "rb");
	$contents = fread($fpr, filesize ($src));
	fclose($fpr);

	$fpw = fopen($dest, "wb");
	fwrite($fpw, snappy_uncompress($contents));
	//fwrite($fpw, gzuncompress($contents));
	fclose($fpw);
}//end


if(!file_exists(__DIR__.'/'. $opt['f'].'.exe')){
	showError('File not find.');
}

$_srcFile = __DIR__.'/'.$opt['f'].'.exe';
$_destFile = __DIR__.'/'.date('Ymd').'.upkg';
$_chkFile = __DIR__.'/'.date('Ymdhis').'.chk.tmp';

$srcHash = md5_file($_srcFile);
cmsg("\n[源文件 - 位 置]: ". $_srcFile);
cmsg("\n[源文件 - MD5值]: ". $srcHash);

cmsg("\n[准备生成目标文件] ". $_destFile);
xbCompress($_srcFile, $_destFile);

//upkg hash chk
cmsg("\n[目标文件已生成!]");
$destHash = md5_file($_destFile);
cmsg("\n[目标文件 - MD5值]: ". $destHash);

//chk uncompress
cmsg('[目标文件 - 校验处理]');
xbUncompress($_destFile, $_chkFile);
$chkHash = md5_file($_chkFile);
unlink($_chkFile);

if($chkHash != $srcHash)
{
	showError("Build update file failure, please try again.");
}
cmsg("[目标文件 - 校验处理完成]". PHP_EOL);
cmsg('OUTPUT INFORMATION:');
cmsg(str_repeat('-', 20));

$resposeMsg=<<<DOC
'service'         => 'xbSpeed',
'updateMode'      => 'install',
'lastVersion'     => '$_version_',
'lastVersionCode' => %s,
'releaseTime'     => '%s',
'lowCompatible'   => '5.1',
'arch'            => '32+64',
'fileName'        => '%s',
'fileSize'        => %s,
'fileHash'        => '%s',
'downloadUrl'     => 'http://ctr.datacld.com/fs/svc/xbspeed/upgrade/%s.upkg',
DOC;

echo sprintf($resposeMsg.PHP_EOL, 
date("Ymd"),
date("Y/m/d"),
basename($_srcFile),
filesize($_destFile),
$destHash,
date("Ymd")
);
cmsg(str_repeat('-', 20));

//把原文件加日期版本归档
$svcname = substr(basename($_srcFile), 0, -4);
if(!is_dir(__DIR__. '/archive')) mkdir (__DIR__.'/archive');
if(!is_dir(__DIR__. '/archive/'. $svcname)) mkdir (__DIR__.'/archive/'. $svcname);

$archiveDest = __DIR__. '/archive/'. $svcname . '/' . date("Ymd")."-".basename($_srcFile);
if(is_file($archiveDest)){unlink($archiveDest);}

rename(__DIR__ . '/' . basename($_srcFile), $archiveDest);

cmsg(PHP_EOL."[源文件归档于]: " . $archiveDest . PHP_EOL);

CMSG("非常好, 所有操作都正确完成!");


CMSG(PHP_EOL."操作提示:".PHP_EOL);
CMSG("mv -f ".basename($_destFile)." /DYFS/site/datacld.com/ctr/public/fs/svc/xbspeed/upgrade/". PHP_EOL);

exit(0);
*/