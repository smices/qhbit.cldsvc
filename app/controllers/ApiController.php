<?php
use Phalcon\Security,
    Phalcon\Paginator\Adapter\Model as Paginator,
    DYP\Sys\Command AS CMD,
    DYP\Agreement\Metapole as DMeta,
    DYP\Response\Simple as Resp;


class ApiController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
        $this->view->disable();

        if(!$this->cookies->has('uuid')) {
            $sess_id = md5(uniqid()+microtime());
            $this->cookies->set('uuid', $sess_id, time()+ 3600*24*365, '/');
            if(!$this->session->isStarted()){
                $this->session->setId($sess_id);
                $this->session->start();
            }

            $this->cookies->send();
        }else{
            if(!$this->session->isStarted()){
                $this->session->setId($this->cookies->get('uuid'));
                $this->session->start();
            }
        }

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
     * 软件管理服务
     */
    public function swmgrAction(){

        if($this->request->isGet()){
            /**
             * 获取软件信息或软件列表
             */
            if($this->request->hasQuery('id') && is_numeric($this->request->getQuery('id'))){
                //获取单个软件的全部信息

            }

            /**
             * 处理软件清单
             */
            $curentPage = $this->request->getQuery('page', 'int', '1');
            $pSize = $this->request->getQuery('psize', 'int', '60');
            $categoryId = $this->request->getQuery('category_id', 'int', '0');

            $phql = "SELECT SP.*, SC.* FROM SwmgrCategory AS SC, SwmgrPackage AS SP
                  WHERE SP.category=SC.id AND SP.status=1 AND SC.status=1";

            $packages = $this->modelsManager->createQuery($phql);
            $paginator = new Paginator(array(
                "data" => $packages,
                "limit" => $pSize,
                "page" => $curentPage
            ));
            $result = $paginator->getPaginate();

            var_dump($result);
            /*HTTP GET METHOD END*/
        }
    }


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

        $service = Service::findFirst(array('name'=>strtolower($svc)));
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


    }//end


    /**
     * 汇报
     */
    public function reportAction(){

    }//end

}//end
