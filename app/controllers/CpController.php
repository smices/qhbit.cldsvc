<?php
use DYP\Response\Simple as Resp;

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
     * 写入配置文件Cache
     * @param $svcName
     *
     * @return bool
     */
    public function putSvcConfig($svcName, $contents)
    {
        $cfFile = _DYP_DIR_CFG . '/ServiceControl/' . $svcName . '.cache.php';
        if(file_put_contents($cfFile, $contents)){
            return true;
        }else{
            return false;
        }
    }//end

    /**
     * Index
     */
    public function indexAction()
    {

        //$phql = "SELECT Service.* FROM Service INNER JOIN Counter ON Service.id = Counter.svc";
        $svc_sql = "SELECT Service.*, Counter.* FROM Service INNER JOIN Counter ON Service.id = Counter.svc";
        $svc_rs = $this->modelsManager->executeQuery($svc_sql);
        $this->view->svc = $svc_rs;

    }//end

    /**
     * xbSpeed Service
     */
    public function xbspeedAction(){
        /**
         * 汇入旧的文件配置表
         */
        /*
        $task = new XbspeedTask();
        if($cfg = $this->getSvcConfig('xbspeed')){
            foreach($cfg->files as $k=>$v){
                $task = new XbspeedTask();
                $task->id=null;
                $task->fileName=$v->fileName;
                $task->storage=$v->storage;
                $task->fileSize=$v->fileSize;
                $task->fileHash=$v->fileHash;
                $task->uploadSpeed=$v->uploadSpeed;
                $task->downloadUrl=$v->downloadUrl;
                $task->tdConfigUrl=$v->tdConfigUrl;
                $task->create();
                $task = null;
            }
        }
        die;
        */

        if($this->request->isPut()){
            $this->view->disable();
            /**
             * PUT Method , Create config cache file, (*service).cache.php
             */
            $currentTime = time();
            $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'xbspeed'));
            $task = XbspeedTask::find();
            $vsvc->vcode = $currentTime;
            $vsvc->save();

            $taskls = [];
            $taskls['version'] = $currentTime;
            $taskls['files'] = [];
            foreach($task->toArray() as $k=>$v){
                if($v['status'] ==2 || $v['status'] ==0) continue;
                unset($v['id']);
                unset($v['status']);
                $v['fileSize']     = floatval($v['fileSize']);
                $v['uploadSpeed']  = floatval($v['uploadSpeed']);
                $taskls['files'][] = $v;

            }

            $contents="<?php".PHP_EOL
                     ."//*--------------------------------------------------------*/".PHP_EOL
                     ."// XBSpeed 服务控制配置".PHP_EOL
                     ."//*--------------------------------------------------------*/".PHP_EOL
                     ."\$cf=" . var_export($taskls, true) . ";".PHP_EOL
                     ."return \$cf;".PHP_EOL;

            if($this->putSvcConfig('xbspeed', $contents)){
                Resp::outJsonMsg(0, 'SUCESS');
            }else{
                Resp::outJsonMsg(1, 'WRITE CACHE FAILURE');
            }
        }elseif($this->request->isPost()){
            $this->view->disable();
            /**
             * Post method, Create a new record.
             */


        }elseif($this->request->isDelete()){
            $this->view->disable();
            /**
             * Delete method, disabled record(s)
             */

        }else{
            /**
             * Get method or other method , show operation page.
             */
            $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'xbspeed'));
            $task = XbspeedTask::find();
            if ($task) {
                $this->view->task = $task;
                $this->view->vsvc = $vsvc;
            } else {
                $this->view->list = null;
            }
        }

    }//end

    /**
     * 核心服务管理
     */
    public function coresvcAction(){
        if($cfg = $this->getSvcConfig('_upgrade')){
            $this->view->list = $cfg;
            $str="<?php\n".'$cf=' . var_export($cfg->toArray(), true) . ";\n".'return $cf;';
            //echo file_put_contents('R:\shm\_upgrade.php', $str);
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
            //echo file_put_contents('R:\shm\_software.php', $str);

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
