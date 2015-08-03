<?php
namespace DYPA\Models;
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
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $nickname;

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
     * @var integer
     */
    public $cents;

    /**
     *
     * @var datetime
     */
    public $ctime;

    /**
     *
     * @var datetime
     */
    public $ltime;

    /**
     *
     * @var datetime
     */
    public $mtime;

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
