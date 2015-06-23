<?php
namespace DYP\Sys;

class Command{

    /**
     * 循环检测并创建文件夹
     *
     * @param $path 文件夹路径
     * @rturn boolean
     */
    static public function mkdirs($path){
        if (!is_dir($path)){
            self::mkdirs(dirname($path));
            @mkdir($path, 0777);
        }
    }//end



    /**
     * 获取用户真实 IP
     */
    static public function getClientRealIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }


        return $realip;
    }//endfunc

    /**
     * 格式化 数据大小 为最容易理解的称呼
     * @param $size
     *
     * @return string
     */
    static public function fmtDataSize ($size){
        $unit=array('byte','K','M','G','T','P');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).$unit[$i];
    }//end


}//end
