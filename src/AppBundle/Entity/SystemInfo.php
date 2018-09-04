<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SystemInfo
 *
 * @ORM\Table(name="system_info")
 * @ORM\Entity
 */
class SystemInfo
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="ts", type="bigint")
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_fk", type="integer")
     */
    private $feedbackFk;

    /**
     * @var integer
     *
     * @ORM\Column(name="version_code", type="integer")
     */
    private $versionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="version_name", type="string")
     */
    private $versionName;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string")
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string")
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string")
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="os_version", type="string")
     */
    private $osVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string")
     */
    private $userName;

    /**
     * Get timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param integer $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Get feedbackFk
     *
     * @return integer
     */
    public function getFeedbackFk()
    {
        return $this->feedbackFk;
    }

    /**
     * @param integer $feedbackFk
     */
    public function setFeedbackFk($feedbackFk)
    {
        $this->feedbackFk = $feedbackFk;
    }

    /**
     * Get versionCode
     *
     * @return integer
     */
    public function getVersionCode()
    {
        return $this->versionCode;
    }

    /**
     * @param integer $versionCode
     */
    public function setVersionCode($versionCode)
    {
        $this->versionCode = $versionCode;
    }

    /**
     * Get versionName
     *
     * @return string
     */
    public function getVersionName()
    {
        return $this->versionName;
    }

    /**
     * @param string $versionName
     */
    public function setVersionName($versionName)
    {
        $this->versionName = $versionName;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Get osVersion
     *
     * @return string
     */
    public function getOsVersion()
    {
        return $osVersion->osVersion;
    }

    /**
     * @param string $osVersion
     */
    public function setOsVersion($osVersion)
    {
        $this->osVersion = $osVersion;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $userName->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

}
