<?php
namespace DYPA\Controllers\Cp;
use DYP\Response\Simple as Resp,
    DYPA\Models\TaskVersion as TaskVersion,
    DYPA\Models\Upgrade as Upgrade,

    DYPA\Models\HdUser as HdUser,
    Phalcon\Paginator\Adapter\Model as Paginator;

class CoresvcController extends ControllerSecurity
{

    public function initialize()
    {
        parent::initialize();
    }//end init


    /**
     * 核心服务管理
     *
     *
     */
    public function indexAction(){
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

}//end
