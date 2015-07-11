<?php
class Upgrade extends \Phalcon\Mvc\Model
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

    public $service;

	/**
     *
     * @var enum
     */
    public $updateMode;
    /**
     *
     * @var string
     */
    public $lastVersion;

    /**
     *
     * @var integer
     */
    public $lastVersionCode;

    /**
     *
     * @var datetime
     */
    public $releaseTime;
    /**
     *
     * @var enum
     */
    public $lowCompatible;

    /**
     *
     * @var enum
     */
    public $arch;

    /**
     *
     * @var string
     */
    public $fileName;

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
     * @var string
     */
    public $downloadUrl;

    /**
     *
     * @var enum
     */
    public $channel;

}
