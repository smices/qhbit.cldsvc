<?php
namespace DYPA\Controllers;
use Phalcon\Mvc\Controller,
    Phalcon\Translate\Adapter\NativeArray,
    DYP\Response\Simple as Resp,
    DYP\Sys\Errors as DYERR;

class ControllerSecurityAPI extends ControllerBase
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;
    public static $MSG_HTML=0;
    public static $MSG_JSON=1;
    public static $MSG_TEXT=2;

    /**
     * Controller Initialization
     */
    public function initialize()
    {
        if($this->request->hasQuery('token')) session_id($this->request->getQuery('token'));
        parent::initialize();

        self::$TIMESTAMP_NOW = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
        //$this->Authentication();
    }//endfunc

    /**
     * Account Authentication
     *
     * @param int $msgType
     * @return AuthenticationError
     */
    public function Authentication($msgType=1){

        //simple check
        if (!$this->session->has("secure")) {
            return $this->AuthenticationError(DYERR::AC_AUTH_NO_SECURITY, $msgType);
        }

        $ssesData = $this->session->get("secure");
        if (empty($ssesData['id']) || empty($ssesData['username']) || empty($ssesData['password'])) {
            return $this->AuthenticationError(DYERR::AC_AUTH_NO_MATCH, $msgType);
        }

        //Check form database
        $rs = User::findFirstByid($ssesData['id']);
        if (!$rs) {
            return $this->AuthenticationError(DYERR::AC_AUTH_NO_SECURITY, $msgType);
        }
        $rs = $rs->toArray();
        if($rs['username'] != $ssesData['username'] || $rs['password'] != $ssesData['password'] )
        {
            return $this->AuthenticationError(DYERR::AC_AUTH_NO_SECURITY, $msgType);
        }
    }//endfunc

    /**
     * have Error Process
     *
     * @param string $msgText
     * @param int $msgType
     * @return bool
     */
    public function AuthenticationError($msgText, $msgType=1)
    {
        if($msgType == self::$MSG_JSON){
            Resp::outJsonMsg(9, $msgText, $this->request);
        }elseif($msgType == self::$MSG_HTML){
            Resp::outHtmlMsg($msgText);
        }else{
            Resp::outJsonMsg(9, $msgText, $this->request);
        }

    }//endfunc


}//end class
