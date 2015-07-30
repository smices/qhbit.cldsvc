<?php
namespace DYPA\Controllers\Api;
use DYP\Response\Simple as Resp;


class IndexController extends ControllerApi
{

    public function initialize()
    {
        parent::initialize();

    }//end init

    /**
     * Index
     */
    public function indexAction()
    {
        if($this->request->isOptions()){
            Resp::outHtmlMsg(file_get_contents(_DYP_DIR_APP.DIR_SEP.'doc/api.txt'));
        }elseif($this->request->isGet()){
            Resp::outHtmlMsg("[PRIVATELY] CLOUD CONTROL CENTER APPLICATION INTERFACE.");
        }else{
            Resp::outJsonMsg(1, 'TYPE ERROR', $this->request);
        }
    }//end

}//end
