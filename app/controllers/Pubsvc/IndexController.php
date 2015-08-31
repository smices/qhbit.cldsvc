<?php
namespace DYPA\Controllers\Pubsvc;

class IndexController extends ControllerPubsvc
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
        $this->chkToken();
    }//end

}//end
