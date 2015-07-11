<?php
use Phalcon\Security,
    DYP\Sys\Command AS CMD,
    DYP\Response\Simple as Resp;

class ApiController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
        $this->view->disable();
    }//end init

    /**
     * Index
     */
    public function indexAction()
    {
        if($this->request->isOptions()){
            Resp::outHtmlMsg(file_get_contents(_DYP_DIR_APP.DIR_SEP.'doc/api.txt'));
        }elseif($this->request->isGet()){
            Resp::outHtmlMsg("[PRIVATELY] CLOUD CONTROL CENTER APPLICATION INTERFACE.");
        }else{
            Resp::outJsonMsg(1, 'TYPE ERROR', $this->request);
        }
    }//end

    /**
     * 获取需要下载的文件列表清单
     */
    public function softwareAction(){
        $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本

        if(!is_file(realpath(_DYP_DIR_CFG .'/ServiceControl/_software.php'))) {
            Resp::outJsonMsg(1, 'LIST NOT FIND', $this->request);
        }

        $cfg = new Phalcon\Config\Adapter\Php(realpath(_DYP_DIR_CFG .'/ServiceControl/_software.php'));
        if($cfg){
            if(0 == $cfv || (int) $cfv < (int) $cfg->version){
                //unset($cfg->config);
                Resp::outJsonMsg(0, $cfg->toArray());
            }else{
                Resp::outJsonMsg(9, 'NO UPDATE');
            }
        }else{
            Resp::outJsonMsg(1, "UNKNOWN ERROR");
        }
    }//end

    /**
     * 获取我方程序更新列表
     */
    public function upgradeAction(){

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


    /**
     * 服务控制
     */
    public function ctrAction(){
        $svc = $this->request->getQuery('svc', 'string', null); //服务名称
        $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本
        $hw  = $this->request->getQuery('hw', 'string', null); //系统所有盘的硬件Serial Number

        if($svc == null){
            Resp::outJsonMsg(1, 'PARAM LOST');
        }

        $service = Service::findFirst(array('name'=>$svc));
        if(!$service){
            Resp::outJsonMsg(1, 'SERVICE NOT FIND');
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



/*
        $cfFile = _DYP_DIR_CFG .'/ServiceControl/'.$svc.'.php';
        $cfCacheFile = _DYP_DIR_CFG .'/ServiceControl/'.$svc.'.cache.php';

        if(!is_file(realpath($cfCacheFile)) && !is_file(realpath($cfFile))){
            Resp::outJsonMsg(1, 'UNKNOWN SERVICE');
        }
        if(is_file(realpath($cfCacheFile))){
            $cfg = new Phalcon\Config\Adapter\Php(realpath($cfCacheFile));
            $cfg->source = substr(basename($cfCacheFile), 0, -4);
        }else{
            $cfg = new Phalcon\Config\Adapter\Php(realpath($cfFile));
            $cfg->source = substr(basename($cfFile), 0, -4);
        }

        if(0 == $cfv || (int) $cfv < (int) $cfg->version){

            Resp::outJsonMsg(0, $cfg->toArray());
        }else{
            Resp::outJsonMsg(9, 'NO UPDATE');
        }

*/
    }//end

}//end
