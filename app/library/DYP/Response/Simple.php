<?php
namespace DYP\Response;
class Simple{

    const JSON = 'application/json;charset=utf-8';
    const XML  = 'text/xml;charset=utf-8';
    const HTML = 'text/html;charset=utf-8';

    static public function message($code, $msg){
        return array("code"=>$code, "msg"=>$msg);
    }//end

    static public function jsonMsg($code, $msg, $request=null){
        if($request == null || !$request->hasQuery('callback')){
            return json_encode(self::message($code, $msg), JSON_UNESCAPED_UNICODE);
        }else{
            return $request->getQuery("callback") ."(". json_encode(self::message($code, $msg), JSON_UNESCAPED_UNICODE) . ");";
        }
    }//end

    /**
     * 输出 HTML 格式内容并且 默认退出
     * @param $msg
     * @param bool $exit
     */
    static public function outHtmlMsg($msg, $exit=true){
        self::sendContentTypeHeader(self::HTML);
        self::sendCustomHeader('CResponseType', 'HTML');
        echo $msg;
        if(true == $exit){
            exit(0);
        }
    }//endfunc

    static public function outJsonMsg($code, $msg, $request=null, $exit=true){
        self::sendContentTypeHeader(self::JSON);
        self::sendCustomHeader('CResponseType', 'JSON');
        echo self::jsonMsg($code, $msg, $request=null);
        if(true == $exit){
            exit(0);
        }
    }//endfunc


    static public function sendContentTypeHeader($type="json"){
        $type = strtolower($type);
        header('Content-Type: '.$type);
    }

    /**
     * Send Custom Header
     * @param $key
     * @param $val
     * @return null
     */
    static public function sendCustomHeader($key, $val){
        header($key.': '.$val);
    }//endf

}//end
