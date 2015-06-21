<?php
//use Detection\MobileDetect;

class IndexController extends ControllerBase
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
        $this->view->disable();
        echo "<h1>抱歉, 云控中心暂时停止服务.</h1>";
        echo "<h2>Sorry, Cloud Control Panel Stopped!</h2>";
        //$this->response->redirect("http://hao.360.cn");

    }//end

}//end
