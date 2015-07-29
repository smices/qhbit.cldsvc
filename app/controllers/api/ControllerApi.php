<?php
namespace DYPA\Controllers\Api;
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
/*

        if(!$this->cookies->has('uuid')) {
            $sess_id = md5(uniqid()+microtime());
            $this->cookies->set('uuid', $sess_id, time()+ 3600*24*365, '/');
            if(!$this->session->isStarted()){
                $this->session->setId($sess_id);
                $this->session->start();
            }

            $this->cookies->send();
        }else{
            if(!$this->session->isStarted()){
                $this->session->setId($this->cookies->get('uuid'));
                $this->session->start();
            }
        }*/

    }
}//end class
