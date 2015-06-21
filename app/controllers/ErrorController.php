<?php
//use Detection\MobileDetect;

class ErrorController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * Index
     */
    public function e404Action()
    {
        $this->view->disable();
		echo "<h1>HTTP 404 ERROR</h1>";
        echo "<h2>Page not find.</h2>";
    }//end

}//end
