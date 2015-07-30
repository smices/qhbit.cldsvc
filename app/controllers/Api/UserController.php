<?php
namespace DYPA\Controllers\Api;
use DYPA\Models\User as User,
    DYPA\Models\DataCounter as DataCounter,
    DYP\Response\Simple as Resp;


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
             * 获取用户登录状态等相关内容
             * 如果没有登录, 则返回失败
             */
        }elseif($this->request->isPost()){
            /**
             * 更新用户内容
             */
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


}//end
