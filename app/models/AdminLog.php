<?php


use Phalcon\Mvc\Model\Validator\Email as Email;

class AdminLog extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var integer
     */
    public $uid;
     
     
    /**
     *
     * @var datetime
     */
    public $time;
     
    /**
     *
     * @var string
     */
    public $ip;
     

}
