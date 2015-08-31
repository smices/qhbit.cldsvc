<?php
namespace DYPA\Controllers\User;
use DYP\Response\Simple as Resp;


class IndexController extends ControllerUser
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
		$this->chkMethod();

    }//end

}//end
