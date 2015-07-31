<?php
namespace DYPA\Controllers\Api;
use DYPA\Models\User as User,
    DYPA\Models\DataCounter as DataCounter,
    DYP\Response\Simple as Resp,
    DYP\Security\Crypt as uCrypt ;


class UserController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();
    }//end init

    /**
     * 用户信息获取
     */
    public function indexAction(){
        if($this->request->isGet()){
            /**
             * 获取用户登录状态等相关内容, 如续令牌等操作
             * 如果没有登录, 则返回失败
             */
        }elseif($this->request->isPost()){
            /**
             * 用户登录操作
             */
            $user = $this->request->getPost('user', 'string', null);
            $pwd = $this->request->getPost('pwd', 'string', null);
            if(null == $user || null == $pwd){
                Resp::outJsonMsg(1, 'USERNAME OR PASSWORD EMPTY OR PASSWORD NOT ENCODE');
            }
            $rsUser = User::findFirst(sprintf("username='%s'", $user));
            if($rsUser){
                //chk pwd
                if(true == uCrypt::uPasswordCompare($pwd, $rsUser->password, false)){
                    if(!$this->session->isStarted()) $this->session->start();
                    $uInfo = array_merge($rsUser->toArray(), array('token'=>$this->session->getId()));
                    unset($uInfo['password']);
                    $this->session->set('uProfile',$uInfo);
                    Resp::outJsonMsg(0,$uInfo);
                }else{
                    Resp::outJsonMsg(3,'PASSWORD ERROR');
                }

            }else{
                Resp::outJsonMsg(2, 'USER NOT FIND');
            }

        }
    }//end

    /**
     * 用户注册
     */
    public function registerAction(){
        if(!$this->request->isPost()) Resp::outJsonMsg(1, 'METHOD ERROR');

        $user = new User();
        $user->id = null;
        $user->username;
        $user->password;
        $user->mobile;
        $user->nickname;
        $user->type;
        $user->openid;
        $user->token;
        $user->gender;
        $user->address;
        $user->ctime = SELF::$TIMESTAMP_MYSQL_FMT;
        $user->valid;
        $user->status = 1;

        if($user->create()){
            $DataCounter = DataCounter::findFirst("user");
            $DataCounter->num++;
            if($DataCounter->update()){
                Resp::outJsonMsg(0, 'SUCCESS');
            }
            Resp::outJsonMsg(0, 'SUCCESS');
        }else{
            $err = array();
            foreach ($user->getMessages() as $message) {$err[] = $message;}
            Resp::outJsonMsg(1, join(",", $err), $this->request);
        }
    }//end


    /**
     * 获取用户资料 必须要登录后才可以获取
     */
    public function profileAction(){
        if($this->request->isGet()){
            /**
             * 获取登录后的指定用户全部资料
             */
            return $this->_profile_get();
        }elseif($this->request->isPost()){
            /**
             * 更新登录后的指定用户资料
             */
            return $this->_profile_post();
        }else{
            Resp::outJsonMsg(1, 'METHOD ERROR');
        }
    }//end

    /**
     * Link profileAction Method::get
     */
    private function _profile_get(){}//end

    /**
     * Link profileAction Method::post
     */
    private function _profile_post(){}//end

}//end
