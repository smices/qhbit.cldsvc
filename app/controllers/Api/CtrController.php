<?php
namespace DYPA\Controllers\Api;
use DYP\Response\Simple as Resp,
    DYPA\Models\Service as Service,
    DYPA\Models\HdUser as HdUser,
    DYPA\Models\Counter as Counter;


class CtrController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * 服务控制
     */
    public function indexAction(){
        $svc = $this->request->getQuery('svc', 'string', null); //服务名称
        $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本
        $hw  = $this->request->getQuery('hw', 'string', null); //系统所有盘的硬件Serial Number

        if($svc == null){
            $this->DYRespond(1, 'PARAM LOST');
        }

        $service = Service::findFirst(array('name'=>strtolower($svc)));
        if(!$service){
            $this->DYRespond(1, 'SERVICE NOT FIND');
        }
        $counter = Counter::findFirst($service->id);

        if($counter){

            $counter->request =$counter->request +1;
            if(null != $hw){
                //处理用户唯一性, 表示本服务已经被正确安装,同时开始正确服务
                $hduser = new HdUser();
                $find_sn = $hduser::findFirst(sprintf('sn="%s"', $hw));

                if(!$find_sn) {
                    //服务下载计数+1
                    $counter->download = $counter->download + 1;
                    //添加SN到HDUser用户表
                    $hduser->id = null;
                    $hduser->sn = trim($hw);
                    $hduser->ctime = parent::$TIMESTAMP_MYSQL_FMT;
                    $hduser->mtime = parent::$TIMESTAMP_MYSQL_FMT;

                    $hduser->create();
                }
            }
            $counter->update();
        }

        //带Cache处理数据块
        $cacheKey = 'SYS0:svc_'.$svc.'.igb';
        $rInfo   = $this->memCache->get($cacheKey);
        $_fromCache = true;
        if ($rInfo === null) {
            $rFile = _DYP_DIR_CFG .'/release_ctr/svc_'.$svc.'.igb';

            if(!is_file(realpath($rFile))) {
                $this->DYRespond(1, 'LIST NOT FIND', $this->request);
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
                $this->DYRespond(0, $rInfo);
            }else{
                $this->DYRespond(9, 'NO UPDATE');
            }
        }else{
            $this->DYRespond(1, "UNKNOWN ERROR");
        }


    }//end

}//end
