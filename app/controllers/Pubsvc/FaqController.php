<?php
namespace DYPA\Controllers\Pubsvc;


class FaqController extends ControllerPubsvc
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
        $this->chkMethod(array(self::$METHOD_GET));//Method Check

    }//end

}//end
