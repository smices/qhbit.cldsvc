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
        $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本

        if(!is_file(realpath(_DYP_DIR_CFG .'/ServiceControl/_upgrade.php'))) {
            Resp::outJsonMsg(1, 'LIST NOT FIND', $this->request);
        }
        $cfg = new Phalcon\Config\Adapter\Php(realpath(_DYP_DIR_CFG .'/ServiceControl/_upgrade.php'));
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
                var_dump($find_sn);
                if(!$find_sn) {
                    //服务下载计数+1
                    $counter->download = $counter->download + 1;
                    //添加SN到HDUser用户表
                    $hduser->id = null;
                    $hduser->sn = trim($hw);
                    $hduser->ctime = parent::$TIMESTAMP_MYSQL_FMT;
                    $hduser->mtime = parent::$TIMESTAMP_MYSQL_FMT;

                    if(!$hduser->create()){
                        var_dump($hduser->getMessages());
                    }
                }
            }
            $counter->update();
        }

        $cfFile = _DYP_DIR_CFG .'/ServiceControl/'.$svc.'.php';
        if(!is_file(realpath($cfFile))){
            Resp::outJsonMsg(1, 'UNKNOWN SERVICE');
        }
        $cfg = new Phalcon\Config\Adapter\Php(realpath($cfFile));

        if(0 == $cfv || (int) $cfv < (int) $cfg->version){
            Resp::outJsonMsg(0, $cfg->toArray());
        }else{
            Resp::outJsonMsg(9, 'NO UPDATE');
        }

    }//end

}//end
