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
        */

        $this->view->TotalUnique = $this->view->HistoryVisitors = $this->view->OnlineUser = 'Unknown';

        if(strtolower(PHP_OS) == 'linux'){
            $awstatsFile = "/DYFS/storage/awstats/awstats".date("mY").".ctr.datacld.com.txt";
        }else{//for test
            $awstatsFile = "D:/usr/local/Apache64/temp/awstats".date("mY").".ctr.datacld.com.txt";//Test
        }

        if(is_file($awstatsFile)){
            $str = file_get_contents($awstatsFile);
            $s = strpos($str,'BEGIN_GENERAL');
            if ($s) $str = substr($str,$s);
            $e=strpos($str,'END_GENERAL');//寻找位置
            if ($e) $str = substr($str,0, $e);//删除后面
            $awlist = explode("\n", $str);
            $startWith = function ($str, $needle) {return strpos($str, $needle) === 0;};
            foreach($awlist as $v){
                if($startWith($v, 'TotalUnique')) $this->view->TotalUnique = trim(str_replace("TotalUnique","", $v));
            }
        }

    }//end

    /**
     * Exit Login
     */
    public function logoutAction()
    {
        $this->view->disable();
        $_SERVER['PHP_AUTH_USER'] = null;
        $_SERVER['PHP_AUTH_PW']   = null;
        $this->response->redirect("cp/index");
        exit(0);
    }//end


    /**
     * xbSpeed Service Management
     *
     *
     */
    public function xbspeedAction()
    {
        if ($this->request->isPut()) {
            $this->view->disable();
            /**
             * PUT Method , Create config cache file, (*service).cache.php
             */
            $currentTime = time();
            $vsvc        = TaskVersion::findFirst(sprintf('name="%s"', 'xbspeed'));
            $task        = XbspeedTask::find('status=1');
            $vsvc->vcode = $currentTime;
            $vsvc->save();

            $taskls            = [];
            $taskls['version'] = $currentTime;
            $taskls['files']   = [];
            foreach ($task->toArray() as $k => $v) {
                if ($v['status'] == 2 || $v['status'] == 0) continue;
                unset($v['id']);
                unset($v['status']);
                $v['fileSize']     = floatval($v['fileSize']);
                $v['uploadSpeed']  = floatval($v['uploadSpeed']);
                $taskls['files'][] = $v;
            }

            //序列化, 写入内容
            $strSerial = igbinary_serialize($taskls);
            //Gen cache file by json format
            $igbFile = _DYP_DIR_CFG . '/release_ctr/svc_xbspeed.igb';
            if (file_put_contents($igbFile, $strSerial)) {
                if ($this->memCache->exists('SYS0:svc_xbspeed.igb')) {
                    $this->memCache->delete('SYS0:svc_xbspeed.igb');
                }
                Resp::outJsonMsg(0, 'SUCCESS', $this->request);
            } else {
                Resp::outJsonMsg(1, 'WRITE CACHE FAILURE', $this->request);
            }

        } elseif ($this->request->isPost()) {
            $this->view->disable();
            /**
             * Post method, Create a new record.
             */
            $task              = new XbspeedTask();
            $task->id          = null;
            $task->fileName    = $this->request->getPost('field_fileName', 'string', null);
            $task->storage     = $this->request->getPost('field_storage', 'string', null);
            $task->fileSize    = $this->request->getPost('field_fileSize', 'int');
            $task->fileHash    = strtolower($this->request->getPost('field_fileHash', 'string'));
            $task->uploadSpeed = $this->request->getPost('field_uploadSpeed', 'int');
            $task->downloadUrl = $this->request->getPost('field_downloadUrl', 'string');
            $task->tdConfigUrl = 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/' . $task->fileName . '.td.cfg';
            $task->status      = 1;
            if (empty($task->fileName) || empty($task->fileSize) || strlen($task->fileHash) != 32 ||
                empty($task->uploadSpeed) || empty($task->downloadUrl)
            ) {
                Resp::outJsonMsg(1, 'FIELD EMTPY', $this->request);
            }
            if ($task->create()) {
                Resp::outJsonMsg(0, 'SUCCESS', $this->request);
            } else {
                $err = array();
                foreach ($task->getMessages() as $message) {
                    $err[] = $message;
                }
                Resp::outJsonMsg(1, join(",", $err), $this->request);

            }

        } elseif ($this->request->isDelete()) {
            $this->view->disable();
            /**
             * Delete method, disabled record(s)
             */
            $params = array();
            parse_str($this->request->getRawBody(), $params);
            if (!isset($params['id']) && !is_numeric($params['id'])) {
                Resp::outJsonMsg(1, 'RECORD ID LOST');
            }
            $task = XbspeedTask::findFirst(sprintf('id = %d AND status <> 2', $params['id']));
            if ($task) {
                //Resp::outJsonMsg(1, 'SUCCESS');
                $task->status = 2;
                if ($task->update()) {
                    Resp::outJsonMsg(0, 'SUCCESS');
                } else {
                    Resp::outJsonMsg(1, 'RECORD UPDATE FAILED');
                }
            } else {
                Resp::outJsonMsg(1, 'RECORD NOT FIND');
            }
            /* REMOVE ONE RECORD PROCESS END */
        } elseif ($this->request->isPatch()){
            /**
             * Edit same fields
             */
            $this->view->disable();
            parse_str($this->request->getRawBody(), $params);
            if (!isset($params['id']) ||
                !isset($params['field_fileName']) ||
                !isset($params['field_fileSize']) ||
                !isset($params['field_fileHash']) ||
                strlen(trim($params['field_fileHash'])) != 32 ||
                !isset($params['field_uploadSpeed']) ||
                !isset($params['field_downloadUrl']) ||
                !isset($params['field_status'])
            ) {
                Resp::outJsonMsg(1, 'FIELD EMTPY', $this->request);
            }

            $task               = XbspeedTask::findFirst($params['id']);

            if($task->fileName != trim($params['field_fileName'])) {
                $task->fileName = trim($params['field_fileName']);
                $task->tdConfigUrl = 'http://ctr.datacld.com/fs/svc/xbspeed/tdConfigUrl/' . $task->fileName . '.td.cfg';
            }

            if($task->storage  != trim($params['field_storage'])) $task->storage = trim($params['field_storage']);
            if($task->fileSize != trim($params['field_fileSize']))  $task->fileSize = trim($params['field_fileSize']);
            if($task->fileHash != trim($params['field_fileHash']))  $task->fileHash = trim($params['field_fileHash']);
            if($task->uploadSpeed != $params['field_uploadSpeed']) $task->uploadSpeed = trim($params['field_uploadSpeed']);
            if($task->downloadUrl != $params['field_downloadUrl']) $task->downloadUrl = trim($params['field_downloadUrl']);
            if($task->status != $params['field_status']) $task->status = trim($params['field_status']);

            if ($task->update()) {
                Resp::outJsonMsg(0, 'SUCCESS', $this->request);
            } else {
                $err = array();
                foreach ($task->getMessages() as $message) {
                    $err[] = $message;
                }
                Resp::outJsonMsg(1, join(",", $err), $this->request);
            }

        }else{
            /**
             * Get method or other method , show operation page.
             */

            if($this->request->hasQuery('id')){
                /**
                 * Edit a record
                 */
                $task = XbspeedTask::findFirst(sprintf('id=%d AND status <> 2', $this->request->getQuery('id', 'int')));

                if ($task) {
                    $this->view->record = $task;
                }
                /*EDIT END*/
            }else {
                $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'xbspeed'));
                $task = XbspeedTask::find('status <> 2');
                if ($task) {
                    $this->view->task = $task;
                    $this->view->vsvc = $vsvc;
                } else {
                    $this->view->list = null;
                }
            }
        }

    }//end


    /**
     * 核心服务管理
     *
     *
     */
    public function coresvcAction(){
        if($this->request->isGet()){
            /**
             * Get method or other method , show operation page.
             */
            $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'upgrade'));
            $task = Upgrade::find();
            if ($task) {
                $this->view->task = $task;
                $this->view->vsvc = $vsvc;
            } else {
                $this->view->list = null;
            }
        }elseif($this->request->isPut()){
            $this->view->disable();
            /**
             * 生成发行文件, 供API调用
             */

            $task = Upgrade::find();
            $list = array();
            $list['version'] = self::$TIMESTAMP_NOW;
            $list['files'] = array();
            foreach($task->toArray() as $k=>$v){
                unset($v['id']);
                unset($v['channel']);
                $v['lastVersionCode'] = floatval($v['lastVersionCode']);
                $v['fileSize']     = floatval($v['fileSize']);
                $list['files'][] = $v;
            }
            //刷新版本
            $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'upgrade'));
            $vsvc->vcode = self::$TIMESTAMP_NOW;
            $vsvc->save();

            $strSerial = igbinary_serialize($list);
            $igbFile = _DYP_DIR_CFG .'/release_ctr/upgrade.igb';
            if(file_put_contents($igbFile, $strSerial)){
                if($this->memCache->exists('SYS0:upgrade.igb')){$this->memCache->delete('SYS0:upgrade.igb');}
                Resp::outJsonMsg(0, 'SUCCESS', $this->request);
            }else{
                Resp::outJsonMsg(1, 'WRITE CACHE FAILURE', $this->request);
            }
        }
    }//end


    /**
     * 数据分析管理
     *
     *
     */
    public function analysisAction(){

    }//end


    /**
     * 软件管家管理
     *
     *
     *
     */
    public function swmgrAction(){
        if($this->request->isPost()){
            $this->view->disable();
            /**
             * Upload a new software package
             */

            $picJs2Php = function($jsStr){
                //if(empty(trim($jsStr))) Resp::outJsonMsg(1, 'UPLOAD FILE EMPTY');
                if(empty(trim($jsStr))) return '';
                $tmpAr = [];
                foreach(explode(',', $jsStr) as $k=>$v){
                    if(trim($v) == '') continue;
                    $tmpAr[] = $v;
                }
                return join(',', $tmpAr);
            };

            $pkg                 = new SwmgrPackage();
            $pkg->id             = null;
            $pkg->packageName    = $this->request->getPost('packageName', 'string');
            $pkg->windowsVersion = $this->request->getPost('windowsVersion', 'string');
            $pkg->arch           = $this->request->getPost('arch', 'int');
            $pkg->name           = $this->request->getPost('name', 'string');
            $pkg->category       = $this->request->getPost('category', 'int');
            $pkg->description    = $this->request->getPost('description', 'string');
            $pkg->developer      = $this->request->getPost('developer', 'string');
            $pkg->iconUrl        = $this->request->getPost('hide_iconUrl', 'string');
            $pkg->largeIcon      = $this->request->getPost('hide_largeIcon', 'string');
            $pkg->screenshotsUrl = $picJs2Php($this->request->getPost('hide_screenshotsUrl', 'string'));
            $pkg->incomeShare    = $this->request->getPost('incomeShare', 'int');
            $pkg->rating         = $this->request->getPost('rating', 'int');
            $pkg->versionName    = $this->request->getPost('versionName', 'string');
            $pkg->versionCode    = $this->request->getPost('versionCode', 'int');
            $pkg->priceInfo      = $this->request->getPost('priceInfo', 'string');
            $pkg->tag            = $this->request->getPost('tag', 'string');
            $pkg->downloadUrl    = $this->request->getPost('downloadUrl', 'string');
            $pkg->hash           = strtolower($this->request->getPost('hash', 'string'));
            $pkg->size           = $this->request->getPost('size', 'int');
            $pkg->createTime     = self::$TIMESTAMP_MYSQL_FMT;
            $pkg->updateTime     = self::$TIMESTAMP_MYSQL_FMT;
            $pkg->signature      = md5(uniqid(microtime()));
            $pkg->updateInfo     = $this->request->getPost('updateInfo', 'string');
            $pkg->language       = $this->request->getPost('language', 'string');
            $pkg->brief          = $this->request->getPost('brief', 'string');
            $pkg->isAd           = $this->request->getPost('isAd', 'int');
            $pkg->status         = $this->request->getPost('status', 'int');

            if($pkg->create()){
                $SwmgrCategory = SwmgrCategory::findFirst($pkg->category);
                $SwmgrCategory->total =$SwmgrCategory->total+1;
                if($SwmgrCategory->update()){
                    Resp::outJsonMsg(0, 'SUCCESS');
                }
                Resp::outJsonMsg(0, 'SUCCESS');
            }else{
                $err = array();
                foreach ($pkg->getMessages() as $message) {$err[] = $message;}
                Resp::outJsonMsg(1, join(",", $err), $this->request);
            }
            /*UPLOAD A NEW SOFTWARE PACKAGE*/
        }elseif($this->request->isPut()){
            $this->view->disable();
            /**
             * Update software package info
             */

        }elseif($this->request->isGet()){
            /**
             * Show manager and list
             * Get method or other method , show operation page.
             */
            if($this->request->hasQuery('mode')){
                /**
                 * 带模式的处理块
                 */

                if('create' == $this->request->getQuery('mode', 'string')){
                    /**
                     * CREATE SWMGRPACKAGE
                     **/
                    $this->view->templeName = 'create';
                    $this->view->task       = SwmgrPackage::findFirst(1);
                    /*CREATE SWMGRPACKAGE*/
                }elseif('edit' == $this->request->getQuery('mode', 'string')){
                    /**
                     * EDIT SWMGRPACKAGE
                     */
                    $this->view->templeName = 'edit';
                    $this->view->error = false;

                    if(!$this->request->hasQuery('id') || !is_numeric($this->request->getQuery('id'))){
                        $this->view->error = true;
                        $this->view->msg = 'ID NOT FIND';
                    }else{

                        $this->view->task       = SwmgrPackage::findFirst($this->request->getQuery('id', 'int'));
                    }
                    /*EDIT SWMGRPACKAGE*/
                }
            }else {
                /**
                 * MAIN PAGE
                 */
                $vsvc = TaskVersion::findFirst(sprintf('name="%s"', 'swmgr'));
                $task = SwmgrPackage::find();
                if ($task) {
                    $this->view->task = $task;
                    $this->view->vsvc = $vsvc;
                } else {
                    $this->view->list = null;
                }
            }
        }

    }//end

    /**
     * 软件管理之分类管理
     */
    public function swmgrCategoryAction(){
        if($this->request->isPost()){
            $this->view->disable();
            /**
             * Upload a new software package
             */
            if($this->request->hasPost('action') && $this->request->getPost('action', 'string') == 'edit'){
                /*Edit Record*/
                $id = $this->request->getPost('id', 'int', null);
                if(null == $id){
                    Resp::outJsonMsg(1, 'ID LOST');
                }

                $category         = SwmgrCategory::findFirst($id);

                if($this->request->hasPost('name') && !empty($this->request->getPost('name', 'string'))) {
                    $category->name = $this->request->getPost('name', 'string');
                }
                if($this->request->hasPost('alias') && !empty($this->request->getPost('alias', 'string'))){
                    $category->alias  = $this->request->getPost('alias', 'string');
                }
                /*
                if($this->request->hasPost('total') && 0 != $this->request->getPost('total', 'int')) {
                    $category->total = $this->request->getPost('total', 'int');
                }
                */
                $category->status = $this->request->getPost('status', 'int');

                if($category->update()){
                    Resp::outJsonMsg(0, 'SUCCESS');
                }else{
                    $err = array();
                    foreach ($category->getMessages() as $message) {
                        $err[] = $message;
                    }
                    Resp::outJsonMsg(1, join(",", $err), $this->request);
                }

            }/*EDIT UPLDATE*/

            /**
             * 添加一个分类
            */
            if(!$this->request->hasPost('name') || empty($this->request->getPost('name', 'string')) ||
                !$this->request->hasPost('status') || empty($this->request->getPost('status', 'int'))){
                Resp::outJsonMsg(1, 'SOME FIELD EMPTY');
            }
            $category         = new SwmgrCategory();
            $category->id     = null;
            $category->pid    = 0;
            $category->name   = $this->request->getPost('name', 'string');
            $category->order  = 0;

            if($this->request->hasPost('alias')){
                $category->alias  = $this->request->getPost('alias', 'string');
            }

            $category->total  = 0;
            $category->status = $this->request->getPost('status', 'int');

            if($category->create()){
                Resp::outJsonMsg(0, 'SUCCESS');
            }else{
                $err = array();
                foreach ($category->getMessages() as $message) {
                    $err[] = $message;
                }
                Resp::outJsonMsg(1, join(",", $err), $this->request);
            }
            /*CREATE RECORD END*/

        }elseif($this->request->isPut()){
            $this->view->disable();
            /**
             * Update software package info
             */
        }elseif($this->request->isGet()){
            /***
             * Show manager and list
             * Get method or other method , show operation page.
             */
            $vsvc = Service::findFirst(sprintf('name="%s"', 'swmgr'));

            $task = SwmgrCategory::find(array('columns'=>'id, name,alias,total,status'));
            if ($task) {
                $this->view->task = $task;
                $this->view->vsvc = $vsvc;
            } else {
                $this->view->list = null;
            }
        }

    }//end


    public function swmgrAnalysisAction(){}//end


    /**
     * UI AJAX 通用文件上传
     */
    public function fileuploadAction(){
        $this->view->disable();
        $savePath = 'sw'.DIR_SEP.date('y').DIR_SEP.date('m').DIR_SEP.date('d').DIR_SEP;
        if(!is_dir(_DYP_DIR_FS.DIR_SEP.$savePath)) DYP\Sys\Command::mkdirs(_DYP_DIR_FS.DIR_SEP.$savePath);
        if ($this->request->hasFiles() == true){
            $fileList = [];
            foreach ($this->request->getUploadedFiles() as $file) {
                //echo $file->getName(), " ", $file->getSize(), "\n";
                $fileName = md5($file->getName().microtime()).substr($file->getName(), -4);
                $file->moveTo(_DYP_DIR_FS.DIR_SEP.$savePath.$fileName);
                $fileList[] = '/fs/'.str_replace(DIR_SEP, '/', $savePath.$fileName);
            }
            Resp::outJsonMsg(0, join(',', $fileList), $this->request);
        }else{
            Resp::outJsonMsg(1, 'NO FILE UPLOAD', $this->request);
        }
    }//end


    /**
     * 检查远程文件是否存在
     *
     *
     */
    public function rfexistsAction(){
        $this->view->disable();
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
