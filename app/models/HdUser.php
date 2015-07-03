<?php


use Phalcon\Mvc\Model\Validator\Email as Email;

class HdUser extends \Phalcon\Mvc\Model
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
    public $sn;

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