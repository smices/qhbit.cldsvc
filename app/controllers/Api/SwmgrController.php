<?php
namespace DYPA\Controllers\Api;
use DYPA\Models\SwmgrPackage as SwmgrPackage,
    DYPA\Models\SwmgrCategory as SwmgrCategory,
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

}//end
