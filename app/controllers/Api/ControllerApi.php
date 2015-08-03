<?php
namespace DYPA\Controllers\Api;

use Phalcon\Mvc\Controller,
    DYP\Response\Simple AS Resp;

class ControllerApi extends Controller
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;
    public static $OUTPUT_FMT = Resp::JSON;

    public static $METHOD_GET     = 'GET';
    public static $METHOD_POST    = 'POST';
    public static $METHOD_DELETE  = 'DELETE';
    public static $METHOD_PUT     = 'PUT';
    public static $METHOD_OPTIONS = 'OPTIONS';
    public static $METHOD_HEAD    = 'HEAD';

    public function initialize()
    {
        $this->view->disable();
        self::$TIMESTAMP_NOW       = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);

        if ($this->request->has('_fmt') && 'bmsg' == strtolower($this->request->get('_fmt', 'string'))) {
            self::$OUTPUT_FMT = Resp::MSGPACK;
        }

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
                }
        */

    }//end

    /**
     * Response Message formater
     *
     * @param int    $code
     * @param string $msg
     * @param null   $request
     */
    public function DYRespond($code = 0, $msg = '', $request = null)
    {
        Resp::outMsg(self::$OUTPUT_FMT, $code, $msg, $request);
    }//end


    /**
     * 检查一个接口所接受的模式, 如果不在范围, 抛出Method error, 并且终止执行
     *
     * @param array $methods
     *
     * @return bool
     */
    public function chkMethod(array $methods)
    {
        if (!$this->request->isMethod($methods)) {
            $this->response->setStatusCode(405);
            $this->response->send();
            $this->DYRespond(405, 'METHOD NOT ALLOWED');
        } else {
            return true;
        }
    }//end

}//end class
