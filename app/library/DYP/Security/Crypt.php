<?php
namespace DYP\Security;

class Crypt{
    /**
     * 用户密码加密, 从被加密过1次的密码到入库
     *
     * @param      $password
     * @return bool|string
     */
    static public function uPassword($password){
        for ($i = 0; $i < 5; $i++){
            $salt = substr($password, 16, 16);
            $password = sha1($password.$salt);
        }
        return md5($password);
    }//end


    /**
     * 模拟客户端建立密码,完整的从明文到入库
     * @param $password
     * @return bool|string
     */
    static public function uPasswordCreate($password){
        $p1 = md5($password);
        $salt = substr($p1, 8, 8);
        $p2= sha1($password.$salt);
        return self::uPassword($p2);
    }//end


    /**
     * 用户存储好的密码和新输入的密码进行比对
     *
     * @param      $noCryptedPasswprd
     * @param      $CryptedPasswd
     * @param      $OriginalHashed
     * @return bool
     */
    static public function uPasswordCompare($noCryptedPasswprd, $CryptedPasswd, $OriginalHashed = true)
    {
        if(true == $OriginalHashed){
            return ($CryptedPasswd == self::uPassword($noCryptedPasswprd)) ? true : false;
        }else{
            return ($CryptedPasswd == self::uPasswordCreate($noCryptedPasswprd)) ? true : false;
        }
    }//end

}//end
