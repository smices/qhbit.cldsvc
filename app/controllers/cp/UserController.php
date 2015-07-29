<?php
namespace DYPA\Controllers\Cp;
use DYP\Response\Simple as Resp,
    DYPA\Models\HdUser as HdUser,
    DYPA\Models\Service as Service,
    DYPA\Models\User as User,
    Phalcon\Paginator\Adapter\Model as Paginator;

class UserController extends ControllerSecurity
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * Index
     */

    /**
     * 通过正式注册的用户管理
     */
    public function indexAction(){
        $currPage = $this->request->getQuery('page', 'int', 1);
        $ulist = HdUser::find(array('status'=>1, 'columns'=>'id,sn,ctime', 'order'=>'id DESC'));

        if (count($ulist) == 0) {
            $this->view->title="QUERY FAIL";
            $this->view->msg="NOT FOUND ANY USERS";
            return $this->dispatcher->forward(array("controller" => "cp","action" => "error"));
        }

        $paginator = new Paginator(array(
            "data" => $ulist, // Data to paginate
            "limit" => 50, // Rows per page
            "page" => $currPage // Active page
        ));

        $this->view->page = $paginator->getPaginate();
    }//end



    /**
     * 基于用户硬件, 硬盘序列号的用户管理
     */
    public function hduserAction(){
        $currPage = $this->request->getQuery('page', 'int', 1);
        $ulist = HdUser::find(array('columns'=>'id,sn,ctime', 'order'=>'id DESC'));

        if (count($ulist) == 0) {
            $this->view->title="QUERY FAIL";
            $this->view->msg="NOT FOUND ANY USERS";
            return $this->dispatcher->forward(array("controller" => "cp","action" => "error"));
        }

        $paginator = new Paginator(array(
            "data" => $ulist, // Data to paginate
            "limit" => 50, // Rows per page
            "page" => $currPage // Active page
        ));

        $this->view->page = $paginator->getPaginate();
    }//end


}//end
