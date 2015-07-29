<?php
namespace DYPA\Controllers\Cp;
use DYP\Response\Simple as Resp,
    DYPA\Models\TaskVersion as TaskVersion,
    DYPA\Models\XbspeedTask as XbspeedTask,
    DYPA\Models\Counter as Counter,
    Phalcon\Paginator\Adapter\Model as Paginator;

class XbspeedController extends ControllerSecurity
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * xbSpeed Service Management
     *
     *
     */
    public function indexAction()
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


}//end
