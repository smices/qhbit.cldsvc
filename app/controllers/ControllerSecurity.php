<?php
use Phalcon\Mvc\Controller,
    DYP\Security\Crypt as DYCrypt,
    DYP\Sys\Errors as DYERR;

class ControllerSecurity extends Controller
{
    public static $TIMESTAMP_NOW;
    public static $TIMESTAMP_MYSQL_FMT;

    /**
     * Controller Initialization
     */
    public function initialize()
    {
        self::$TIMESTAMP_NOW = time();
        self::$TIMESTAMP_MYSQL_FMT = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW);
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
        if(!$this->BasicAuthentication())die("<h1>Forbidden</h1>");
        //$this->view->setViewsDir(_DYP_DIR_VIEW);
    }

    /**
     * Basic HTTP Authentication
     * @return bool
     */
    public function BasicAuthentication(){
        $auth_ok=0;
        $user=$_SERVER['PHP_AUTH_USER'];
        $pass=DYCrypt::uPassword($_SERVER['PHP_AUTH_PW']);
        $admin = Admin::findFirst("username='$user' AND password='$pass'");
        if(isset($user) && isset($pass) && $admin){
            $auth_ok=1;
        }

        if(!$auth_ok)
        {
            header('WWW-Authenticate: Basic realm="Security Area, Please Login."');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        }
        return true;
    }

}//end class
