<?php
namespace DYPA\Models;
class SwmgrCategory extends \Phalcon\Mvc\Model
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
    public $pid;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $alias;

    /**
     *
     * @var integer
     */
    public $total;

    /**
     *
     * @var integer
     */
    public $order;

    /**
     *
     * @var integer
     */
    public $status;

}
