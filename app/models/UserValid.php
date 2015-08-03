<?php
namespace DYPA\Models;
class UserValid extends \Phalcon\Mvc\Model
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
    public $type;

    /**
     *
     * @var integer
     */
    public $vaild;

    /**
     *
     * @var datetime
     */
    public $expire;

}
