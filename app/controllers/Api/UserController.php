<?php
namespace DYPA\Controllers\Api;

use DYPA\Models\User,
    DYPA\Models\DataCounter,
    DYP\Security\Crypt as uCrypt,
    DYPA\Models\UserValid,
    Phalcon\Exception,
    Phalcon\Mvc\Model\Transaction\Manager as TxManager,
    Phalcon\Mvc\Model\Transaction\Failed as TxFailed;


class UserController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
        if (!$this->session->isStarted()) $this->session->start();
        if ($this->request->hasQuery('token')) session_id($this->request->getQuery('token', 'string'));
    }//end init

    /**
     * 必须要登录后才可使用的接品, 需要检查令牌
     * 如果检查令牌失败, 直接抛出错误返回
     */
    private function chkToken()
    {
        if ($this->request->hasQuery('token')) {
            if ($this->session->has('entered') && true == $this->session->get('entered')) {
                $this->session->touchTime = self::$TIMESTAMP_NOW;

                return true;
            } else {
                $this->DYRespond(1, 'PLEASE LOGIN FIRST');
            }
        } else {
            $this->DYRespond(1, 'TOKEN NOT FIND');
        }
    }//end

    /**
     * 用户信息获取
     */
    public function indexAction()
    {

        $this->chkMethod(array(self::$METHOD_GET, self::$METHOD_POST));//Method Check

        if ($this->request->isGet()) {
            /**
             * 获取用户登录状态等相关内容, 如续令牌等操作
             * 如果没有登录, 则返回失败
             */
            $this->chkToken();
            $this->DYRespond(0, 1200);
        } elseif ($this->request->isPost()) {
            /**
             * 用户登录操作
             */
            $user = $this->request->getPost('username', 'string', null);
            $pwd  = $this->request->getPost('password', 'string', null);
            $type = $this->request->getPost('type', 'string', 'username');
            if (null == $user || null == $pwd) {
                $this->DYRespond(1, 'USERNAME OR PASSWORD EMPTY OR PASSWORD NOT ENCODE');
            }
            if ('username' == $type) {
                $rsUser = User::findFirst(sprintf("username='%s'", $user));
            } elseif ('mobile' == $type) {
                $rsUser = User::findFirst(sprintf("mobile='%s'", $user));
            }
            if ($rsUser) {
                //chk pwd
                if (true == uCrypt::uPasswordCompare($pwd, $rsUser->password, true)) {

                    //EMAIL NOT VALID
                    /*
                    if (0 == $rsUser->email_valid) {
                        $this->DYRespond(4, 'EMAIL NOT VALID');
                    }
                    */

                    $uInfo = $rsUser->toArray();
                    unset($uInfo['password']);
                    unset($uInfo['openid']);
                    unset($uInfo['token']);
                    unset($uInfo['type']);
                    $uInfo = array_merge($uInfo, array(
                            'token'     => $this->session->getId(),
                            'touchTime' => self::$TIMESTAMP_NOW
                        )
                    );
                    $this->session->set('uProfile', $uInfo);
                    $this->session->touchTime = self::$TIMESTAMP_NOW;
                    $this->session->entered   = true;
                    //更新mtime
                    $rsUser->ltime = self::$TIMESTAMP_MYSQL_FMT;
                    $rsUser->update();
                    $this->DYRespond(0, $uInfo);
                } else {
                    $this->DYRespond(3, 'PASSWORD ERROR');
                }

            } else {
                $this->DYRespond(2, 'USER NOT FIND');
            }

        }
    }//end

    /**
     * 用户注册
     */
    public function registerAction()
    {
        $this->chkMethod(array(self::$METHOD_GET, self::$METHOD_POST));//Method Check

        if ($this->request->isGet()) {
            /*注册后验证处理*/
            if (!$this->request->hasQuery('type') || !$this->request->hasQuery('valid')
                || !in_array($this->request->getQuery('type'), array('email', 'mobile'))
            ) {
                $this->DYRespond(1, 'FIELD / TYPE ERROR');
            }
            $_type = $this->request->getQuery('type', 'string');
            $_valid = $this->request->getQuery('valid', 'string');

            if ('email' == $_type) {
                if(!$validStr = $this->crypt->decryptBase64($_valid)){
                    $this->DYRespond(2, 'DECRYPT VALID ERROR');
                }
                $tmpAr = explode("::", trim($validStr));
                if(!is_numeric($tmpAr[0])){
                    $this->DYRespond(3, 'VALID ID ERROR');
                }
                $vaildRs = UserValid::findFirst(sprintf('id=%d AND type=%d', $tmpAr[0], chop($tmpAr[1])));
                if(!$vaildRs) $this->DYRespond(4, 'VALID RECORD NOT FIND');

            } elseif('mobile' == $_type) {

            }else{
                $this->DYRespond(1, 'UNKNOW ERROR');
            }

            /*注册后验证处理*/
        } elseif ($this->request->isPost()) {
            /*用户注册*/

            if (!$this->request->hasPost('username')
                || strlen($this->request->getPost('username', 'string')) < 5
                ||  !preg_match("/^[a-zA-Z]{1,}[a-zA-Z0-9]{4,25}$/", $this->request->getPost('username', 'string'))
            ){
                $this->DYRespond(1, 'USERNAME ERROR '.$this->request->getPost('username', 'string'));
            }

            if (!$this->request->hasPost('email')
                || strlen($this->request->getPost('email', 'string')) < 5
                ||  !preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $this->request->getPost('email', 'string'))
            ){
                $this->DYRespond(1, 'EMAIL ERROR');
            }

            if(!$this->request->hasPost('password') || strlen($this->request->getPost('password', 'string')) != 40) {
                $this->DYRespond(1, 'PASSWORD EMPTY OR PASSWORD NOT ENCODE ' . strlen($this->request->getPost('password', 'string')));
            }

            $rsUser = User::findFirst(sprintf("username='%s'", strtolower($this->request->getPost('username', 'string'))));
            if ($rsUser) {
                $this->DYRespond(2, 'USER EXISTS');
            }

            $rsUserEmail = User::find(sprintf("email='%s'", strtolower($this->request->getPost('email', 'string'))));
            sd($rsUserEmail);
            if ($rsUserEmail) {
                $rsUserEmail = null;
                $this->DYRespond(2, 'EMAIL EXISTS');
            }

            try {
                $manager = $this->di->get('transactions');
                $transaction = $manager->get();

                $user = new User();

                $user->setTransaction($transaction);

                $user->id       = null;
                $user->username = strtolower($this->request->getPost('username'));
                $user->password = uCrypt::uPassword($this->request->getPost('password'));

                if ($this->request->hasPost('mobile'))
                    $user->mobile = $this->request->getPost('mobile', 'int', '');

                if ($this->request->hasPost('email'))
                    $user->email = $this->request->getPost('email', 'string', '');

                if ($this->request->hasPost('nickname'))
                    $user->nickname = $this->request->getPost('nickname', 'string', '');

                if ($this->request->hasPost('type'))
                    $user->type = $this->request->getPost('type', 'int', '');

                if ($this->request->hasPost('openid'))
                    $user->openid = $this->request->getPost('openid', 'string', '');

                if ($this->request->hasPost('token'))
                    $user->token = $this->request->getPost('token', 'string', '');

                if ($this->request->hasPost('gender'))
                    $user->gender = $this->request->getPost('gender', 'int', 2);

                if ($this->request->hasPost('address'))
                    $user->address = $this->request->getPost('address', 'string', '');

                $user->cents        = 10;
                $user->ctime        = SELF::$TIMESTAMP_MYSQL_FMT;
                $user->ltime        = SELF::$TIMESTAMP_MYSQL_FMT;
                $user->mtime        = SELF::$TIMESTAMP_MYSQL_FMT;
                $user->email_valid  = 0;
                $user->mobile_valid = 0;
                $user->status       = 1;

                if (false == $user->save()) {
                    $transaction->rollback("CAN'T CREATE USER");
                }
                /*
                $uVaild = new UserValid();
                $uVaild->id = null;
                $uVaild->type = 0;
                $uVaild->vaild = 0;
                $uVaild->expire = date("Y-m-d H:i:s", self::$TIMESTAMP_NOW+86400);//1天后过期

                if (!$uVaild->create()) {
                    $this->db->rollback();
                    $err = array();
                    foreach ($uVaild->getMessages() as $message) {
                        $err[] = $message;
                    }
                    $this->DYRespond(1, 'USER VALID TRANSACTIONS ERROR,'.join(",", $err));
                }
                */

                $DataCounter = DataCounter::findFirst("name='user'");
                $DataCounter->setTransaction($transaction);
                $DataCounter->num++;
                if (false == $DataCounter->update()) {
                    $transaction->rollback("REFRESH COUNTER ERROR");
                }

                //Submit Transaction
                $transaction->commit();

                //发送邮件
                //未配置邮件服务器. 跳过发送

                /*
                $textMsg = '';
                $htmlMsg = '';
                sendMail($GLOBALS['config']['mail'], $user->email, $subject, $user->username, array('text'=>$textMsg, 'html'=>$htmlMsg));
                */

                $this->DYRespond(0, 'SUCCESS');
            } catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
                $this->DYRespond(40, 'FAILED, REASON: '.$e->getMessage());
            }

            $this->DYRespond(41, 'FAILED UNKNOW');
            /*用户注册*/
        }
    }//end


    /**
     * 获取用户资料 必须要登录后才可以获取
     */
    public function profileAction()
    {
        $this->chkToken();
        $this->chkMethod(array(self::$METHOD_GET, self::$METHOD_PUT));//Method Check


        if ($this->request->isGet()) {
            /**
             * 获取登录后的指定用户全部资料
             */
            return $this->_profile_get();
        } elseif ($this->request->isPut()) {
            /**
             * 更新登录后的指定用户资料
             */
            return $this->_profile_post();
        }
    }//end

    /**
     * Link profileAction Method::get
     */
    private function _profile_get()
    {
    }//end

    /**
     * Link profileAction Method::post
     */
    private function _profile_post()
    {
    }//end


}//end
