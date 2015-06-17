<?php
class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $mobile;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $openid;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var integer
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var datetime
     */
    public $ctime;

    /**
     *
     * @var integer
     */
    public $valid;

    /**
     *
     * @var integer
     */
    public $status;

}
