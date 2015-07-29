<?php
namespace DYPA\Controllers\Api;
use DYP\Response\Simple as Resp;


class UpgradeController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * 获取我方程序更新列表
     */
    public function indexAction(){

        $cacheKey = 'SYS0:upgrade.igb';
        $rInfo   = $this->memCache->get($cacheKey);
        $_fromCache = true;
        if ($rInfo === null) {
            $rFile = _DYP_DIR_CFG .'/release_ctr/upgrade.igb';

            if(!is_file(realpath($rFile))) {
                Resp::outJsonMsg(1, 'LIST NOT FIND', $this->request);
            }
            $rInfo = file_get_contents($rFile);
            //存入缓冲
            $this->memCache->save($cacheKey, $rInfo);
            $_fromCache = false;
        }

        if($rInfo){
            $rInfo = igbinary_unserialize($rInfo);
            $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本
            if(0 == $cfv || (int) $cfv < (int) $rInfo['version']){
                $rInfo['source'] = ($_fromCache)?'mem':'igb';
                Resp::outJsonMsg(0, $rInfo);
            }else{
                Resp::outJsonMsg(9, 'NO UPDATE');
            }
        }else{
            Resp::outJsonMsg(1, "UNKNOWN ERROR");
        }

    }//end

}//end
