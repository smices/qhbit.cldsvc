<?php
use Phalcon\Mvc\Controller;
class ControllerApi extends Controller
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;

    public function initialize(){
        $this->view->disable();
        self::$TIMESTAMP_NOW = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
    }
}//end class
