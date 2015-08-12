<?php
namespace DYPA\Controllers\Cp;
use Phalcon\Mvc\Controller,
    DYP\Response\Simple AS Resp,
    DYP\Security\Crypt as DYCrypt,
    DYPA\Models\Admin as Admin;

class ControllerSecurity extends Controller
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;

    public static $OUTPUT_FMT = Resp::JSON;

    public static $METHOD_GET = 'GET';
    public static $METHOD_POST = 'POST';
    public static $METHOD_DELETE = 'DELETE';
    public static $METHOD_PUT = 'PUT';
    public static $METHOD_OPTIONS = 'OPTIONS';
    public static $METHOD_HEAD = 'HEAD';
    /**
     * Controller Initialization
     */
    public function initialize()
    {
        self::$TIMESTAMP_NOW       = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
        if (!$this->BasicAuthentication()) die("<h1>Forbidden</h1>");

        $this->view->setViewsDir(_DYP_DIR_VIEW.DIR_SEP.'cp/');
        //$this->view->setLayoutsDir(_DYP_DIR_VIEW.DIR_SEP.'layouts/');
        //$this->view->setBasePath(_DYP_DIR_VIEW.DIR_SEP.'cp/');
        //$this->view->setMainView(_DYP_DIR_VIEW.DIR_SEP.'cp/');
        $this->view->setLayout('index');
        //dd($this->view);
    }

    /**
     * Basic HTTP Authentication
     * @return bool
     */
    public function BasicAuthentication()
    {
        $auth_ok = 0;
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $user = $_SERVER['PHP_AUTH_USER'];
            $pass = DYCrypt::uPasswordCreate($_SERVER['PHP_AUTH_PW']);

            $admin = Admin::findFirst("username='$user' AND password='$pass'");

            if (isset($user) && isset($pass) && $admin) {
                $auth_ok = 1;
            }

            if (!$auth_ok) {
                header('WWW-Authenticate: Basic realm="Security Area, Please Login."');
                header('HTTP/1.0 401 Unauthorized');
                exit;
            }

        } else {
            header('WWW-Authenticate: Basic realm="Security Area, Please Login."');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }

        return true;
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
