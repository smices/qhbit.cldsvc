<?php
class CpController extends ControllerSecurity
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * 读取配置文件
     * @param $svcName
     *
     * @return bool|\Phalcon\Config\Adapter\Php
     */
    public function getSvcConfig($svcName)
    {
        $cfFile = _DYP_DIR_CFG . '/ServiceControl/' . $svcName . '.php';
        if (!is_file(realpath($cfFile))) {
            return false;
        } else {
            $cfg = new Phalcon\Config\Adapter\Php(realpath($cfFile));
            if ($cfg) return $cfg;
        }
    }//end

    /**
     * Index
     */
    public function indexAction()
    {

    }//end

    /**
     * xbSpeed Service
     */
    public function xbspeedAction(){
        if($cfg = $this->getSvcConfig('xbspeed')){
            $this->view->list = $cfg;
            $str="<?php\n".'$cf=' . var_export($cfg->toArray(), true) . ";\n".'return $cf;';
            echo file_put_contents('R:\shm\xbspeed.php', $str);
        }else{
            $this->flash->error('NOT FIND CONFIG FILE');
        }
    }//end

    /**
     * 核心服务管理
     */
    public function coresvcAction(){
        if($cfg = $this->getSvcConfig('_upgrade')){
            $this->view->list = $cfg;
            $str="<?php\n".'$cf=' . var_export($cfg->toArray(), true) . ";\n".'return $cf;';
            echo file_put_contents('R:\shm\_upgrade.php', $str);
        }else{
            $this->flash->error('NOT FIND CONFIG FILE');
        }
    }//end

    /**
     * 预装软件管理
     */
    public function presoftwareAction(){
        if($cfg = $this->getSvcConfig('_software')){
            $this->view->list = $cfg;
            $str="<?php\n".'$cf=' . var_export($cfg->toArray(), true) . ";\n".'return $cf;';
            echo file_put_contents('R:\shm\_software.php', $str);

        }else{
            $this->flash->error('NOT FIND CONFIG FILE');
        }



    }//end

    /**
     * 数据分析管理
     */
    public function analysisAction(){

    }//end

}//end
