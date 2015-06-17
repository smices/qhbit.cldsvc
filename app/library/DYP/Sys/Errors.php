<?php
namespace DYP\Sys;

final class Errors{

    const AC_SIGN_UP_EMPTY    = '用户名或密码未设置(填写)';
    const AC_SIGN_U_NO_EXISTS = '用户不存在';
    const AC_SIGN_P_ERROR     = '密码不正确';
    const AC_SIGN_UP_ERROR    = '用户名或密码不正确';
    const AC_SIGN_NO_SECURITY = '不安全的登陆操作';
    const AC_SIGN_NO_VALID    = '账号未验证,处于非激活状态';
    const AC_SIGN_UPDATE_FAIL = '更新账号信息失败';
    const AC_SIGN_CAPTCHA_ERR = '图形验证码错误';

    const AC_EXIT_FAIL        = '账号安全退出失败';
    const AC_EXIT_SUCCESS     = '账号安全退出成功';

    const AC_AUTH_NO_SECURITY = '账号安全认证失败';
    const AC_AUTH_NO_MATCH    = '账号信息不能通过安全检测';

    const METHOD_ERROR        ="错误的的(METHOD)操作方式";
    const RECORD_NOT_FIND     ="未能查找到指定的记录或数据";
    const TYPE_MATCH_ERROR    ="类型不匹配";
    const MUST_FIELD_LOST     ="必要的字段或参数缺失";

    const DECRYPT_FAIL        ="解密数据失败";
    static public function message($code)
    {
        return "<code>INFO: " . strtoupper($code) . ".</code>";
    }//end

    static public function text($code)
    {
        return strtoupper($code) . ".";
    }//end

}//End
