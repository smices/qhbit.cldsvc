<?php
namespace DYPA\Models;
use Phalcon\Mvc\Model\Validator\Email as Email;
class Admin extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var string
     */
    public $email;

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
     * @var string
     */
    public $last_login_time;

    /**
     *
     * @var string
     */
    public $last_login_ip;

    /**
     *
     * @var integer
     */
    public $logins;

    /**
     *
     * @var string
     */
    public $info;

    /**
     *
     * @var string
     */
    public $valid;

    /**
     *
     * @var integer
     */
    public $corp_id;

    /**
     *
     * @var string
     */
    public $role;

    /**
     *
     * @var string
     */
    public $add_time;

    /**
     *
     * @var string
     */
    public $modify_time;

    /**
     *
     * @var string
     */
    public $status;
         public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field"    => "email",
                    "required" => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
