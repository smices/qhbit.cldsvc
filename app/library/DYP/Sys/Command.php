<?php
namespace DYP\Sys;

class Command{

    /**
     * 循环检测并创建文件夹
     *
     * @param $path 文件夹路径
     * @rturn boolean
     */
    static public function mkdirs($path){
        if (!is_dir($path)){
            self::mkdirs(dirname($path));
            @mkdir($path, 0777);
        }
    }//end



    /**
     * 获取用户真实 IP
     */
    static public function getClientRealIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }


        return $realip;
    }//endfunc

    /**
     * 格式化 数据大小 为最容易理解的称呼
     * @param $size
     *
     * @return string
     */
    static public function fmtDataSize ($size){
        $unit=array('byte','K','M','G','T','P');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).$unit[$i];
    }//end

    /**
     * 发送邮件
     * @param array $config
     * @param       $to
     * @param       $subject
     * @param       $name
     * @param       $params
     */
    static public function sendMail(array $config, $to, $subject, $name, $params)
    {
        /*
        $config = array(
            'fromName'=>'发送者名字',
            'fromEmail'=>'发送者邮件地址@gmail.com',
            'smtp'=>array(
                'server'=>'smtp.gmail.com',
                'port'=>'465',
                'security'=>'ssl',
                'username'=>'发送者邮件地址@gmail.com',
                'password'=>''
            )
        */
        include_once _DYP_DIR_LIB. '/swiftmailer/lib/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance($config['smtp']['server'], $config['smtp']['port']);
        $transport->setUsername($config['smtp']['username']);
        $transport->setPassword($config['smtp']['password']);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance();
        $message->setFrom(array($config['fromEmail'] => $config['fromName']));
        $message->setTo(array($to => $name));
        $message->setSubject($subject);

        if(isset($params['text'])){
            $message->setBody($params['text'], 'text/plain', 'utf-8');
        }

        if(isset($params['html'])){
            $message->setBody($params['html'], 'text/html', 'utf-8');
        }

        if(isset($params['attachments'])){
            foreach($params['attachments'] as $f){
                $message->attach(Swift_Attachment::fromPath($f['file'], $f['mime']/*'image/jpeg'*/)->setFilename($f['rename']));
            }
        }

        try{
            $mailer->send($message);
        }catch (Swift_ConnectionException $e){
            echo 'THERE WAS A PROBLEM COMMUNICATING WITH SMTP: ' . $e->getMessage();
        }
    }//end


}//end
