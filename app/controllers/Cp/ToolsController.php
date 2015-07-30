<?php
namespace DYPA\Controllers\Cp;
use DYP\Response\Simple as Resp,
    DYP\Sys\Command as Cmd;

class ToolsController extends \Phalcon\Mvc\Controller
{

    public function initialize()
    {
        $this->view->disable();
    }//end init

    /**
     * Index
     */
    public function indexAction(){
    }//end

    /**
     * UI AJAX 通用文件上传
     */
    public function fileuploadAction()
    {
        $this->view->disable();
        $savePath = 'sw' . DIR_SEP . date('y') . DIR_SEP . date('m') . DIR_SEP . date('d') . DIR_SEP;
        if (!is_dir(_DYP_DIR_FS . DIR_SEP . $savePath)) Cmd::mkdirs(_DYP_DIR_FS . DIR_SEP . $savePath);
        if ($this->request->hasFiles() == true) {
            $fileList = [];
            foreach ($this->request->getUploadedFiles() as $file) {
                //echo $file->getName(), " ", $file->getSize(), "\n";
                $fileName = md5($file->getName() . microtime()) . substr($file->getName(), -4);
                $file->moveTo(_DYP_DIR_FS . DIR_SEP . $savePath . $fileName);
                $fileList[] = '/fs/' . str_replace(DIR_SEP, '/', $savePath . $fileName);
            }
            Resp::outJsonMsg(0, join(',', $fileList), $this->request);
        } else {
            Resp::outJsonMsg(1, 'NO FILE UPLOAD', $this->request);
        }
    }//end


    /**
     * 检查远程文件是否存在
     */
    public function rfexistsAction()
    {
        $this->view->disable();
        $file = $this->request->getQuery('file', 'string');
        if (empty($file)) Resp::outJsonMsg(1, 'FILE ERROR');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file);//不下载
        curl_setopt($ch, CURLOPT_NOBODY, 1);//不取回数据
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);//设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 200) {
            Resp::outJsonMsg(0, '200');
        } elseif ($http_code == 503) {
            Resp::outJsonMsg(0, '503');
        } else {
            Resp::outJsonMsg(1, $http_code);
        }
        /*
        $resp = get_headers($file,1);
        if(preg_match('/200/',$resp[0])){
            Resp::outJsonMsg(0, '200', $this->request);
        }elseif(preg_match('/503/',$resp[0])){
            Resp::outJsonMsg(0, '503', $this->request);
        }else{
            Resp::outJsonMsg(1, join(",", $resp), $this->request);
        }
        */
    }//end

}//end
