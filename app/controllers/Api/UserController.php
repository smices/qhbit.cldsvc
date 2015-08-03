<?php
namespace DYPA\Controllers\Api;

use DYPA\Models\User as User,
    DYPA\Models\DataCounter as DataCounter,
    DYP\Response\Simple as Resp,
    DYP\Security\Crypt as uCrypt;


class UserController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
        if(!$this->session->isStarted()) $this->session->start();
        if($this->request->hasQuery('token')) session_id($this->request->getQuery('token', 'string'));
    }//end init

    /**
     * 必须要登录后才可使用的接品, 需要检查令牌
     * 如果检查令牌失败, 直接抛出错误返回
     */
    private function chkToken(){
        if($this->request->hasQuery('token')) {
            if ($this->session->has('entered') && true == $this->session->get('entered')) {
                $this->session->touchTime = self::$TIMESTAMP_NOW;
                $this->DYRespond(0, 1200);
            } else {
                $this->DYRespond(1, 'PLEASE LOGIN FIRST');
            }
        }else{
            $this->DYRespond(1, 'TOKEN NOT FIND');
        }
    }
    /**
     * 用户信息获取
     */
    public function indexAction()
    {
        if ($this->request->isGet()) {
            /**
             * 获取用户登录状态等相关内容, 如续令牌等操作
             * 如果没有登录, 则返回失败
             */
            if($this->request->hasQuery('token')) {
                if ($this->session->has('touchTime')) {
                    $this->session->inTime = self::$TIMESTAMP_NOW;
                    $this->DYRespond(0, 'DONE');
                } else {
                    $this->DYRespond(1, 'PLEASE LOGIN FIRST');
                }
            }else{
                $this->DYRespond(1, 'TOKEN NOT FIND');
            }

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
                    if (!$this->session->isStarted()) $this->session->start();
                    $uInfo = $rsUser->toArray();
                    unset($uInfo['password']);
                    unset($uInfo['openid']);
                    unset($uInfo['token']);
                    unset($uInfo['type']);
                    $uInfo = array_merge($uInfo, array(
                        'token' => $this->session->getId(),
                        'touchTime'=>self::$TIMESTAMP_NOW)
                    );
                    $this->session->set('uProfile', $uInfo);
                    $this->session->touchTime = self::$TIMESTAMP_NOW;
                    $this->session->entered = true;
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
        if (!$this->request->isPost()) $this->DYRespond(1, 'METHOD ERROR');

        if (!$this->request->hasPost('username')
            || strlen($this->request->getPost('username', 'string'))<5
            || !preg_match("/^[a-zA-Z]{1,}[a-zA-Z0-9]{4,25}$/", $this->request->getPost('username', 'string'))
            || !$this->request->hasPost('password')
            || strlen($this->request->getPost('password')) != 32
        ) {
            $this->DYRespond(1, 'USERNAME OR PASSWORD EMPTY OR USERNAME TOO SHORT OR PASSWORD NOT ENCODE');
        }

        $rsUser = User::findFirst(sprintf("username='%s'", strtolower($this->request->getPost('username'))));
        if ($rsUser) {
            $this->DYRespond(2, 'USER EXISTS');
        }
        $user = new User();

        $user->id       = null;
        $user->username = strtolower($this->request->getPost('username'));
        $user->password = uCrypt::uPassword($this->request->getPost('password'));

        if($this->request->hasPost('mobile'))
            $user->mobile   = $this->request->getPost('mobile', 'int', '');

        if($this->request->hasPost('nickname'))
        $user->nickname = $this->request->getPost('nickname','string', '');

        if($this->request->hasPost('type'))
            $user->type     = $this->request->getPost('type', 'int', '');

        if($this->request->hasPost('openid'))
            $user->openid   = $this->request->getPost('openid', 'string', '');

        if($this->request->hasPost('token'))
            $user->token    = $this->request->getPost('token', 'string', '');

        if($this->request->hasPost('gender'))
            $user->gender   = $this->request->getPost('gender', 'int', 2);

        if($this->request->hasPost('address'))
            $user->address  = $this->request->getPost('address', 'string', '');

        $user->ctime    = SELF::$TIMESTAMP_MYSQL_FMT;
        $user->ltime    = SELF::$TIMESTAMP_MYSQL_FMT;
        $user->mtime    = SELF::$TIMESTAMP_MYSQL_FMT;
        $user->valid    = 0;
        $user->status   = 1;

        if ($user->create()) {
            $DataCounter = DataCounter::findFirst("user");
            $DataCounter->num++;
            if ($DataCounter->update()) {
                $this->DYRespond(0, 'SUCCESS');
            }
            $this->DYRespond(0, 'SUCCESS');
        } else {
            $err = array();
            foreach ($user->getMessages() as $message) {
                $err[] = $message;
            }
            $this->DYRespond(1, join(",", $err), $this->request);
        }
    }//end


    /**
     * 获取用户资料 必须要登录后才可以获取
     */
    public function profileAction()
    {
        if ($this->request->isGet()) {
            /**
             * 获取登录后的指定用户全部资料
             */
            return $this->_profile_get();
        } elseif ($this->request->isPost()) {
            /**
             * 更新登录后的指定用户资料
             */
            return $this->_profile_post();
        } else {
            $this->DYRespond(1, 'METHOD ERROR');
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
