<?php
//use Detection\MobileDetect;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();

/*        $detect = new MobileDetect();
        if ($detect->isMobile() || $detect->isTablet()){
            //转到手机网站
            return $this->dispatcher->forward(array(
                "controller" => "t",
                "action" => "index"
            ));

        }else{
            //转到PC网站
            return $this->dispatcher->forward(array(
                "controller" => "w",
                "action" => "index"
            ));
        }*/
    }//end init

    /**
     * Index
     */
    public function indexAction()
    {
        $this->view->title = _("Welcome!");
    }//end

}//end
