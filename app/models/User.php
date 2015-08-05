<?php
namespace DYPA\Models;
use Phalcon\Mvc\Model\Validator\Uniqueness;
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
    public $email_valid;


    /**
     *
     * @var integer
     */
    public $mobile_valid;

    /**
     *
     * @var integer
     */
    public $status;

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field"   => "username",
                "message" => "The username must be unique"
            )
        ));

        $this->validate(new Uniqueness(
            array(
                "field"   => "email",
                "message" => "The email must be unique"
            )
        ));

        $this->validate(new Uniqueness(
            array(
                "field"   => "mobile",
                "message" => "The mobile must be unique"
            )
        ));

        return $this->validationHasFailed() != true;
    }

}
