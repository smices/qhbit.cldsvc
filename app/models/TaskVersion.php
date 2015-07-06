<?php


use Phalcon\Mvc\Model\Validator\Email as Email;

class TaskVersion extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $vstr;

    /**
     *
     * @var integer
     */
    public $vcode;
}
