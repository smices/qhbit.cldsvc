<?php
namespace DYPA\Controllers\Api;
use DYPA\Models\SwmgrPackage as SwmgrPackage,
    DYPA\Models\SwmgrCategory as SwmgrCategory,
    DYPA\Models\SwmgrUserPackage,
    DYPA\Models\SwmgrClientPackage,
    DYP\Response\Simple as Resp;

class SwmgrController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * 软件管理服务
     */
    public function indexAction(){
        $this->chkMethod(array(self::$METHOD_GET));//Method Check
        if($this->request->isGet()){
            /**
             * 获取软件信息或软件列表
             */
            $type = $this->request->getQuery('type', 'string', null);

            /*获取单个软件的全部信息*/
            if($type == null && $this->request->hasQuery('pkgid') && is_numeric($this->request->getQuery('pkgid'))){
                /*
                $rs = $this->modelsManager->createBuilder()
                    ->from('SwmgrPackage')
                    ->addFrom('SwmgrCategory')
                    ->where(sprintf("SwmgrPackage.id=%d", $this->request->getQuery('id', 'int')))
                    ->andWhere("SwmgrPackage.category = SwmgrCategory.id")
                    ->getQuery()
                    ->getSingleResult();
                d($rs->toArray());
                dd($rs);
                */
                $rs = SwmgrPackage::findFirst($this->request->getQuery('pkgid', 'int'));
                if($rs){
                    $this->DYRespond(0, $rs->toArray());
                }else{
                    $err = array();
                    foreach ($rs->getMessages() as $message) {$err[] = $message;}
                    $this->DYRespond(1, join(",", $err), $this->request);
                }
            }/*获取单个软件的全部信息*/

            /*获取分类信息*/
            if('category' == $type){
                if($this->request->hasQuery('id') && is_numeric($this->request->getQuery('id'))){
                    $rs = SwmgrPackage::find(array('conditions'=>'status=1 AND category='.$this->request->getQuery('id', 'int')));
                }else{
                    $rs = SwmgrCategory::find(array('conditions'=>'status=1', 'columns' => 'id,name,alias,total'));
                }

                if($rs){
                    $this->DYRespond(0, $rs->toArray());
                }else{
                    $err = array();
                    foreach ($rs->getMessages() as $message) {$err[] = $message;}
                    $this->DYRespond(1, join(",", $err), $this->request);
                }
            }/*获取分类信息*/

            /*获取TOP分类软件, 获取推荐软件包, TOP为虚拟分类, 表示所有分成软件*/
            if('top' == $type){
                $rs = SwmgrPackage::find(array('incomeShare=1 AND status=1', 'order'=>'rating DESC, id DESC',"limit" => 100));
                if($rs){
                    $this->DYRespond(0, $rs->toArray());
                }else{
                    $err = array();
                    foreach ($rs->getMessages() as $message) {$err[] = $message;}
                    $this->DYRespond(1, join(",", $err), $this->request);
                }
            }/*获取TOP分类软件*/

            /*获取HOT分类软件,获取热门软件包, HOT为虚拟分类, 表示下载次数最多的软件*/
            if('hot' == $type){
                $rs = SwmgrPackage::find(array('status=1', 'order'=>'rating DESC, id DESC',"limit" => 100));
                if($rs){
                    $this->DYRespond(0, $rs->toArray());
                }else{
                    $err = array();
                    foreach ($rs->getMessages() as $message) {$err[] = $message;}
                    $this->DYRespond(1, join(",", $err), $this->request);
                }
            }/*获取HOT分类软件*/

            /**
             * 处理软件清单
             */
            /**
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
             */
            $this->DYRespond(1, 'PLEASE READ API DOCUMENT');
            /*HTTP GET METHOD END*/
        }
    }//end


    /**
     * 上报用户已经安装过的软件信息
     * 操作windows software table,这个接口不分注册用户, 都可以添加软件信息
     * 无论如何, 接口都会返回正确操作.
     */
    public function clientPackageAction(){
        /*
        $r   = [];
        $r[] = array(
            'caption'           => 'Microsoft DCF MUI (Chinese (Simplified)) 2013',
            'description'       => 'Microsoft DCF MUI (Chinese (Simplified)) 2013',
            'identifyingNumber' => '{90150000-0090-0804-1000-0000000FF1CE}',
            'name'              => 'Microsoft DCF MUI (Chinese (Simplified)) 2013',
            'packageCode'       => '{E3E78C9E-A5F5-4AEB-8A4F-5EE110B4D158}',
            'packageName'       => 'DCFMUI.msi',
            'vendor'            => 'Microsoft Corporation',
        );
        $r[] = array(
            'caption'           => 'ActiveState ActivePython 2.7.8.10 (32-bit)',
            'description'       => 'ActiveState ActivePython 2.7.8.10 (32-bit)',
            'identifyingNumber' => '{EF34E11A-5977-4234-BCDF-6328CA642BC4}',
            'name'              => 'ActiveState ActivePython 2.7.8.10 (32-bit)',
            'packageCode'       => '{9469D219-98CE-47B1-A5FD-1FAB9B0442BE}',
            'packageName'       => 'ActivePython-2.7.8.10-win32-x86.msi',
            'vendor'            => 'ActiveState Software Inc.',
        );

        $data = json_encode($r);
        $len = strlen($data);
        $this->DYRespond($len, $data);
        */

        $this->chkMethod(array(self::$METHOD_POST));//Method Check

        if(!$this->request->hasPost('data') && !$this->request->hasPost('len')){
            $this->DYRespond(1, 'PARAMS ERROR');
        }

        $len = $this->request->getPost('len', 'int');
        $dat = $this->request->get('data');

        if(strlen($dat) != $len){
            $this->DYRespond(1, 'CHECK PARAMS ERROR');
        }

        if(!$dat = json_decode($dat)){
            $this->DYRespond(1, 'UNPACK DATA ERROR');
        }

        $insertCounter = $updateCounter = 0;
        foreach($dat as $k=>$v){
            //s($k, $v);continue;
            $chk = SwmgrClientPackage::findFirst(sprintf('packageCode="%s"', $v->packageCode));
            if($chk){
                //存在记录添加计数
                $chk->installCount++;
                if($chk->update()){
                    $updateCounter++;
                }else{
                    $this->logger->error('UPDATE ERROR,'. $chk->getMessages());
                }
                $chk = null;
                unset($chk);
                continue;
            }else{
                //不存在记录,添加记录
                $ws                    = new SwmgrClientPackage();
                $ws->id                = null;
                $ws->caption           = $v->caption;
                $ws->description       = $v->description;
                $ws->identifyingNumber = $v->identifyingNumber;
                $ws->name              = $v->name;
                $ws->packageCode       = $v->packageCode;
                $ws->packageName       = $v->packageName;
                $ws->vendor            = $v->vendor;
                $ws->installCount      = 1;
                //s($this->db->getSQLStatement());
                if ($ws->create()) {
                    $insertCounter++;
                }else{
                    $this->logger->error('CREATE ERROR,'.$ws->getMessages());
                }
                $chk = $ws = NULL;
                unset($chk);
                unset($ws);
            }
        }

        return $this->DYRespond(0, sprintf('UPDATE %d INSERT %d', $updateCounter, $insertCounter));
    }//end

    /**
     * 上报用户安装软件清单
     * 必须已经处理过 安装软件上报行为后才能使用. 并且必须为注册用户使用接口
     */
    public function userPackageAction(){
/*
        $r = array();
        $r[] = array(
            'uid'=>'99',
            'pkgid'=>'1',
            'installDate'=>'20150717',
            'installLocation'=>'C:\\Program Files\\Microsoft Office\\',
            'installSource'=>'C:\\MSOCache\\All Users\\{90150000-0090-0804-1000-0000000FF1CE}-C\\',
            'localPackage'=>'C:\\Windows\\Installer\\15288e0.msi',
            'packageCache'=>'C:\\Windows\\Installer\\15288e0.msi',
        );
        $r[] = array(
            'uid'=>'99',
            'pkgid'=>'2',
            'installDate'=>'20150714',
            'installLocation'=>'C:\\ProgramData\\Package Cache\\{0E4A9B1A-12D2-4827-BE61-44DBD72797FB}v1.0.5.0\\packages\\TypeScript_VS\\',
            'installSource'=>'E:\\Archives\\',
            'localPackage'=>'C:\\Windows\\Installer\\285adf.msi',
            'packageCache'=>'C:\\Windows\\Installer\\285adf.msi',
        );

        $data = json_encode($r);
        $len = strlen($data);
        $this->DYRespond($len, $data);
*/

        $this->chkMethod(array(self::$METHOD_POST));//Method Check

        //Check Login status
        $this->chkToken();

        //Data Process
        if(!$this->request->hasPost('data') && !$this->request->hasPost('len') && !$this->request->hasPost('uid')){
            $this->DYRespond(1, 'PARAMS ERROR');
        }

        $len = $this->request->getPost('len', 'int');
        $dat = $this->request->getPost('data');
        $uid = $this->session->uProfile->id;
        //$uid = 99;

        //sd($dat, strlen($dat));
        if(strlen($dat) != $len){
            $this->DYRespond(1, 'CHECK PARAMS ERROR');
        }

        if(!$dat = json_decode($dat)){
            $this->DYRespond(1, 'UNPACK DATA ERROR');
        }

        $insertCounter = $updateCounter = 0;
        foreach($dat as $k=>$v) {
            //sd($k, $v);
            $chk = SwmgrUserPackage::findFirst(sprintf('uid=%d AND pkgid=%d', $uid, $v->pkgid));
            if($chk){
                //存在记录添加计数
                $chk->installCount++;
                if($chk->update()){
                    $updateCounter++;
                }else{
                    $this->logger->error('UPDATE ERROR,'. join(',',$chk->getMessages()));
                }
                $chk = null;
                unset($chk);
                continue;
            }else {
                //不存在记录,添加记录
                $uws                  = new SwmgrUserPackage();
                $uws->id              = null;
                $uws->uid             = $uid;
                $uws->pkgid           = $v->pkgid;
                $uws->installDate     = $v->installDate;
                $uws->installLocation = $v->installLocation;
                $uws->installSource   = $v->installSource;
                $uws->localPackage    = $v->localPackage;
                $uws->packageCache    = $v->packageCache;
                $uws->installCount    = 1;
                if ($uws->create()) {
                    $insertCounter++;
                } else {
                    $this->logger->error('CREATE ERROR,' . join(',', $chk->getMessages()));
                }
                $chk = $uws = null;
                unset($chk);
                unset($uws);
            }
        }//endforeach

        return $this->DYRespond(0, sprintf('UPDATE %d INSERT %d', $updateCounter, $insertCounter));

    }//end

}//end
