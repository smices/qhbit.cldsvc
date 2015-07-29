<?php
namespace DYPA\Controllers;
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;

    public function params($name,$value){
        $this->view->setVar($name,$value);
    }

    public function initialize(){
        self::$TIMESTAMP_NOW = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
    }
}//end class
