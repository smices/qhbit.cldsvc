<?php
namespace DYPA\Controllers\Cp;

use DYP\Response\Simple as Resp,
    DYPA\Models\HdUser as HdUser,
    DYPA\Models\Service as Service,
    DYPA\Models\Counter as Counter,
    Phalcon\Paginator\Adapter\Model as Paginator;
use DYPA\Models\SwmgrClientPackage;
use DYPA\Models\SwmgrPackage;
use DYPA\Models\SwmgrUserPackage;

class IndexController extends ControllerSecurity
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

        //Service Total
        $svc_sql         = 'SELECT svc.*, ct.* FROM DYPA\Models\Service AS svc INNER JOIN '.
                           'DYPA\Models\Counter AS ct ON svc.id = ct.svc';
        $svc_rs          = $this->modelsManager->executeQuery($svc_sql);
        $this->view->svc = $svc_rs;

        //HD User Total
        $this->view->userTotal      = HdUser::count();
        $this->view->todayUserTotal = HdUser::count("to_days(ctime)=to_days(now())");//今天
        /*
        $this->view->yesterdayTotal = HdUser::count("TO_DAYS(NOW()) – TO_DAYS(ctime) = 1");//昨天
        $this->view->weekTotal      = HdUser::count("DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ctime)");//昨天
        $this->view->thDayTotal     = HdUser::count("DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(ctime)");//近30天
        $this->view->MonthDayTotal  = HdUser::count("DATE_FORMAT(ctime, '%Y%m' = DATE_FORMAT(CURDATE(), '%Y%m')");//本月
        */

        $this->view->TotalUnique = $this->view->HistoryVisitors = $this->view->OnlineUser = 'Unknown';

        if (strtolower(PHP_OS) == 'linux') {
            $awstatsFile = "/DYFS/storage/awstats/awstats" . date("mY") . ".ctr.datacld.com.txt";
        } else {//for test
            $awstatsFile = "D:/usr/local/AP5.6/temp/awstats.ctr.datacld.com.txt";//Test
        }

        if (is_file($awstatsFile)) {
            $str = file_get_contents($awstatsFile);
            $s   = strpos($str, 'BEGIN_GENERAL');
            if ($s) $str = substr($str, $s);
            $e = strpos($str, 'END_GENERAL');//寻找位置
            if ($e) $str = substr($str, 0, $e);//删除后面
            $awlist    = explode("\n", $str);
            $startWith = function ($str, $needle) {
                return strpos($str, $needle) === 0;
            };
            foreach ($awlist as $v) {
                if ($startWith($v, 'TotalUnique')) $this->view->TotalUnique = trim(str_replace("TotalUnique", "", $v));
            }
        }

        //软件管理部分内容
        $this->view->pkgSrcTotal = SwmgrPackage::count();
        $this->view->pkgClientTotal = SwmgrClientPackage::count();
        $this->view->pkgUserTotal = SwmgrUserPackage::count();

        //软件小计
        $this->view->swmgrSwTop = SwmgrPackage::find(array('', 'order'=>'dlcount DESC', 'limit'=>10));

        //浏览器下载排行
        $this->view->swmgrBrowserTop = SwmgrPackage::find(array('category=3', 'order'=>'dlcount DESC', 'limit'=>10));
    }//end

    /**
     * Exit Login
     */
    public function logoutAction()
    {
        $this->view->disable();
header('WWW-Authenticate: Basic realm="Security Area, Please Login."');
header('HTTP/1.0 401 Unauthorized');
exit;
    }//end

}//end
