<?php
use DYP\Response\Simple as Resp,
    DYP\Sys\FileCache as Fc;

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

		//Service Total
        //$phql = "SELECT Service.* FROM Service INNER JOIN Counter ON Service.id = Counter.svc";
        $svc_sql = "SELECT Service.*, Counter.* FROM Service INNER JOIN Counter ON Service.id = Counter.svc";
        $svc_rs = $this->modelsManager->executeQuery($svc_sql);
        $this->view->svc = $svc_rs;

		//HD User Total
        $this->view->userTotal      = HdUser::count();
        $this->view->todayUserTotal = HdUser::count("to_days(ctime)=to_days(now())");//今天
        /*
        $this->view->yesterdayTotal = HdUser::count("TO_DAYS(NOW()) – TO_DAYS(ctime) = 1");//昨天
        $this->view->weekTotal      = HdUser::count("DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ctime)");//昨天
        $this->view->thDayTotal     = HdUser::count("DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ctime)");//近30天
        $this->view->MonthDayTotal  = HdUser::count("DATE_FORMAT(ctime, '%Y%m' = DATE_FORMAT(CURDATE(), '%Y%m')");//本月
        //dd($this->view->todayTotal);
        */

        $this->view->TotalUnique = $this->view->HistoryVisitors = $this->view->OnlineUser = 'Unknown';

        if(strtolower(PHP_OS) == 'linux'){
            $awstatsFile = "/DYFS/storage/awstats/awstats".date("mY").".ctr.datacld.com.txt";
        }else{//for test
            $awstatsFile = "D:/usr/local/Apache64/temp/awstats".date("mY").".ctr.datacld.com.txt";
        }

        if(is_file($awstatsFile)){
            $str = file_get_contents($awstatsFile);
            $s=strpos($str,'BEGIN_GENERAL');
            if ($s) $str=substr($str,$s);
            $e=strpos($str,'END_GENERAL');//寻找位置
            if ($e) $str=substr($str,0, $e);//删除后面
            $awlist = explode("\n", $str);
            $startWith = function ($str, $needle) {return strpos($str, $needle) === 0;};
            foreach($awlist as $v){
                if($startWith($v, 'TotalUnique')) $this->view->TotalUnique = trim(str_replace("TotalUnique","", $v));
            }
        }

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
            $task = new XbspeedTask();
            $task->id = null;
            $task->fileName = $this->request->getPost('field_fileName', 'string', null);
            $task->storage = $this->request->getPost('field_storage', 'string', null);
            $task->fileSize = $this->request->getPost('field_fileSize', 'int');
            $task->fileHash = $this->request->getPost('field_fileHash', 'string');
            $task->uploadSpeed = $this->request->getPost('field_uploadSpeed', 'int');
            $task->downloadUrl = $this->request->getPost('field_downloadUrl', 'string');
            $task->tdConfigUrl = 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/' . $task->fileName . '.td.cfg';
            $task->status = 1;
            if(empty($task->fileName) || empty($task->fileSize) || strlen($task->fileHash) != 32 ||
                empty($task->uploadSpeed) || empty($task->downloadUrl)){
                Resp::outJsonMsg(1, 'FIELD EMTPY', $this->request);
            }
            if($task->create()){
                Resp::outJsonMsg(0, 'SUCCESS', $this->request);
            }else{
                $err = array();
                foreach ($task->getMessages() as $message) {
                    $err[] = $message;
                }
                Resp::outJsonMsg(1, join(",", $err), $this->request);

            }

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

    public function softmgrAction(){

    }

    /**
     * 检查远程文件是否存在
     */
    public function rfexistsAction(){
        $file = $this->request->getQuery('file', 'string');
        if(empty($file)) Resp::outJsonMsg(1, 'FILE ERROR');
        $resp = get_headers($file,1);
        if(preg_match('/200/',$resp[0])){
            Resp::outJsonMsg(0, '200', $this->request);
        }elseif(preg_match('/503/',$resp[0])){
            Resp::outJsonMsg(0, '503', $this->request);
        }else{
            Resp::outJsonMsg(1, join(",", $resp), $this->request);
        }
    }//end

}//end
