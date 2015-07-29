<?php
namespace DYPA\Controllers\Api;
use DYPA\Models\User as User,
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
        if($this->request->isGet()){
            /**
             * 用户注册状态检测
             */
            $type = $this->request->getQuery('type', 'string', null);
            if(null == $type) Resp::outJsonMsg(1, 'TYPE NOT MATCH');

        }elseif($this->request->isPost()){
            /**
             * 响应用户注册
             */
            Resp::outJsonMsg(1, 'TYPE NOT MATCH');
        }
    }//end


}//end
