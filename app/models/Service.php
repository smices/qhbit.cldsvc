<?php


use Phalcon\Mvc\Model\Validator\Email as Email;

class Service extends \Phalcon\Mvc\Model
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
    public $description;

    /**
     *
     * @var string
     */
    public $depend;

    /**
     *
     * @var datetime
     */
    public $ctime;

    /**
     *
     * @var datetime
     */
    public $mtime;

}
