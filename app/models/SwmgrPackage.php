<?php
namespace DYPA\Models;
class SwmgrPackage extends \Phalcon\Mvc\Model
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
    public $packageName;

    /**
     *
     * @var string
     */
    public $windowsVersion;

    /**
     *
     * @var integer
     */
    public $arch;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $category;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $developer;


    /**
     *
     * @var string
     */
	public $iconUrl;

    /**
     *
     * @var string
     */
	public $largeIcon;

    /**
     *
     * @var string
     */
	public $screenshotsUrl;

    /**
     *
     * @var integer
     */
	public $incomeShare;

	/**
     *
     * @var integer
     */
	public $rating;

    /**
     *
     * @var string
     */
	public $versionName;

    /**
     *
     * @var integer
     */
	public $versionCode;



    /**
     *
     * @var string
     */
	public $priceInfo;

    /**
     *
     * @var string
     */
	public $tag;

    /**
     *
     * @var string
     */
	public $downloadUrl;

    /**
     *
     * @var string
     */
	public $hash;

    /**
     *
     * @var integer
     */
	public $size;



    /**
     *
     * @var string
     */
	public $createTime;

    /**
     *
     * @var string
     */
	public $updateTime;

    /**
     *
     * @var string
     */
	public $signature;

    /**
     *
     * @var string
     */
	public $updateInfo;

    /**
     *
     * @var string
     */
	public $language;

    /**
     *
     * @var string
     */
	public $brief;

	/**
     *
     * @var integer
     */
	public $isAd;

    /**
     *
     * @var integer
     */
    public $status;

}

