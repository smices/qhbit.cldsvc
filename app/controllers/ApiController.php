<?php
use Phalcon\Security,
    DYP\Sys\Command AS CMD,
    DYP\Response\Simple as Resp;

class ApiController extends ControllerBase
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
            Resp::outHtmlMsg(file_get_contents(_DYP_DIR_APP.DIR_SEP.'doc/ctr.txt'));
        }elseif($this->request->isGet()){
            Resp::outHtmlMsg("<h1>欢迎使用小白智能云控系统!<span>&nbsp;".date("Y/m/d H:i")."</span></h1>");
        }else{
            Resp::outJsonMsg(1, 'TYPE ERROR', $this->request);
        }
    }//end

    /**
     * 获取需要下载的文件列表清单
     */
    public function softwareAction(){
        $cfv = $this->request->getQuery('cfv', 'int', 0); //配置文件版本

        if(!is_file(realpath(_DYP_DIR_CFG .'/software.ini'))) {
            Resp::outJsonMsg(1, 'LIST NOT FIND', $this->request);
        }

        $cfg = new Phalcon\Config\Adapter\Ini(realpath(_DYP_DIR_CFG .'/software.ini'));
        if($cfg){
            if(0 == $cfv || (int) $cfv < (int) $cfg->config->version){
                unset($cfg->config);
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

        if(!is_file(realpath(_DYP_DIR_CFG .'/upgrade.ini'))) {
            Resp::outJsonMsg(1, 'LIST NOT FIND', $this->request);
        }
        $cfg = new Phalcon\Config\Adapter\Ini(realpath(_DYP_DIR_CFG .'/upgrade.ini'));
        if($cfg){
            if(0 == $cfv || (int) $cfv < (int) $cfg->config->version){
                unset($cfg->config);
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

        if($svc == null){
            Resp::outJsonMsg(1, 'PARAM LOST');
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
