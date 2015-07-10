<?php
namespace DYP\Sys;

class FileCache{
    const TYPE_JSON = 0;
    const TYPE_TEXT = 1;
    const TYPE_HTML = 2;
    const TYPE_BIN  = 3;

    /**
     * 读取Cache文件, 文件名就是KEY, 先去/dev/shm/DYPFC/ 找, 找不到才去真实的位置找
     *
     * @param $filename
     */
    static public function get($file){
        $cachefn = self::getFileCacheStorage() . md5($file);

        if(is_file($cachefn)){
            return file_get_contents($cachefn);
        }else{
            if(is_file($file)){
                return file_get_contents($file);
            }else{
                return false;
            }
        }
    }//end

    /**
     * 写文件, 文件名就是KEY, 先在真实的位置写入, 再写一份到Cache位置, 默认在/dev/shm/DYPFC
     *
     * @param $filename
     * @param $content
     * @rturn bool
     */
    static public function put($file, $content){
        $rbk = file_put_contents($file, $content);
        if($rbk){
            $cachefn = self::getFileCacheStorage() . md5($file);
            if(!file_put_contents($cachefn, $content)) @error_log('PUT CACHE FILE FAIL');
            return $rbk;
        }else{
            return false;
        }
    }//end

    /**
     * 获取缓冲文件的存放位置
     * @return string
     */
    static public function getFileCacheStorage(){

        if(strpos(strtolower(PHP_OS), 'win') === false){
            $_dir = "/dev/shm/DYPFC";
        }else{
            $_dir = getenv('TEMP');
        }
        return $_dir . DIRECTORY_SEPARATOR;
    }//end

}//end
