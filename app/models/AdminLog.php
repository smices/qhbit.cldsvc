<?php
namespace DYPA\Models;
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
