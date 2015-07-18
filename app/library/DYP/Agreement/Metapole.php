<?php
namespace DYP\Agreement;

class Metapole{

    /**
     * 获取当前生效中的服务配置文件名
     * @param $svc 服务名称
     *
     * @return string
     */
    static public function currentRelSvcCfg($svc){
        $f = realpath(_DYP_DIR_CFG .'/release_ctr/svc_'.$svc.'.igb');
        if(is_file($f)){
            return $f;
        }else{
            return false;
        }
    }//endfunc


    /**
     * 获取当前生效中的服务配置文件存放目录
     *
     * @return string
     */
    static public function currentRelSvcDir(){
        $directory = realpath(_DYP_DIR_CFG .'/release_ctr');
        if(is_dir($directory)){
            return $directory;
        }else{
            return false;
        }
    }//endfunc

}//endclass
