<?php
namespace DYPA\Models;
class SwmgrUserPackage extends \Phalcon\Mvc\Model
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
    public $uid;

    /**
     *
     * @var integer
     */
    public $pkgid;

    /**
     *
     * @var integer
     */
    public $installDate;


    /**
     *
     * @var string
     */
    public $installLocation;

    /**
     *
     * @var string
     */
    public $installSource;

    /**
     *
     * @var string
     */
    public $localPackage;

    /**
     *
     * @var string
     */
    public $packageCache;

    /**
     *
     * @var integer
     */
    public $installCount;

}
