<?php
namespace DYPA\Models;
class SwmgrClientPackage extends \Phalcon\Mvc\Model
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
    public $caption;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $identifyingNumber;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $packageCode;

    /**
     *
     * @var string
     */
    public $packageName;

    /**
     *
     * @var string
     */
    public $vendor;

    /**
     *
     * @var integer
     */
    public $installCount;

}
