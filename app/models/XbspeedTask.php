<?php
namespace DYPA\Models;
class XbspeedTask extends \Phalcon\Mvc\Model
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
    public $fileName;

    /**
     *
     * @var string
     */
    public $storage;

    /**
     *
     * @var integer
     */
    public $fileSize;

    /**
     *
     * @var string
     */
    public $fileHash;

    /**
     *
     * @var integer
     */
    public $uploadSpeed;

    /**
     *
     * @var string
     */
    public $downloadUrl;

    /**
     *
     * @var string
     */
    public $tdConfigUrl;

    /**
     *
     * @var integer
     */
    public $status;

}
