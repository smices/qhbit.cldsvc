<?php
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller
{
    public static $LANGUAGE;

    public function params($name,$value){
        $this->view->setVar($name,$value);
    }

    public function initialize(){

        //I18N
        $baseLang=$this->request->getBestLanguage();
        if(!empty($baseLang) &&
            in_array($baseLang,
                array("en-US", "zh-CN", "zh-TW", "zh-HK"))){
            self::$LANGUAGE = strtolower(str_replace("-", "_", $baseLang));
        }else{
            self::$LANGUAGE = "zh_cn";
        }

        if(!defined('MESSAGES_PACKAGE')) define('MESSAGES_PACKAGE', 'bms'); //语方包名字
        if(!defined('__DIR_LOCALES__')) define('__DIR_LOCALES__', _DYP_DIR_APP.DIR_SEP.'locale');//语言包存放位置

        if($this->session->has("locale") &&
            in_array($this->session->get("locale"), array("en_US","zh_CN","zh_HK","zh_TW"))){
            $locale = $this->session->get("locale");
        }else{
            $locale = str_replace("-", "_", $baseLang);
        }

        if (is_dir(__DIR_LOCALES__.DIR_SEP.$locale)){//可以找到所支持的语言包.
            putenv('LANGUAGE=' . $locale); //ubuntu 需要，centos不需要此行
            putenv('LANG='.$locale);
            putenv("LC_ALL=".$locale.".utf8");
            setlocale(LC_ALL, $locale . '.utf8'); //ubuntu 需要.utf8，centos可有可无
        }else{
            putenv('LANGUAGE=zh_HK'); //ubuntu 需要，centos不需要此行
            putenv("LANG=zh_HK");
            putenv("LC_ALL=zh_HK.utf8");
            setlocale(LC_ALL, "zh_HK.utf8");
        }
        $this->session->set("locale", $locale);
        bindtextdomain(MESSAGES_PACKAGE, __DIR_LOCALES__);
        bind_textdomain_codeset(MESSAGES_PACKAGE, 'UTF-8');
        textdomain(MESSAGES_PACKAGE);

    }
}//end class
