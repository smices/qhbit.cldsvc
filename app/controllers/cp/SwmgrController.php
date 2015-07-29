<?php
namespace DYPA\Controllers\Cp;
use DYP\Response\Simple as Resp,
    DYPA\Models\TaskVersion as TaskVersion,
    DYPA\Models\Service as Service,
    DYPA\Models\SwmgrPackage as SwmgrPackage,
    DYPA\Models\SwmgrCategory as SwmgrCategory,
    Phalcon\Paginator\Adapter\Model as Paginator;

class SwmgrController extends ControllerSecurity
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
     * Create
     */
    public function createAction(){

        $this->view->task       = SwmgrPackage::findFirst(1);


    }//end


    /**
     * 软件管理之分类管理
     */
    public function categoryAction(){
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


}//end