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
        echo "转向hao.360网站...";
        //$this->response->redirect("http://hao.360.cn");

    }//end

}//end
