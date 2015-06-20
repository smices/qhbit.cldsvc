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
        echo "云控中心服务暂时停止服务.";
        //$this->response->redirect("http://hao.360.cn");

    }//end

}//end
