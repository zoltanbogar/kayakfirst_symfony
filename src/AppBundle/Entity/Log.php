<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="log")
 * @ORM\Entity
 */
class Log
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
     * @var string
     *
     * @ORM\Column(name="log", type="string")
     */
    private $log;

    /**
     * Get log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param string $log
     */
    public function setLog($log)
    {
        $this->log = $log;
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
     * @ORM\Column(name="system_info_ts", type="bigint")
     */
    private $systemInfoTimestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_fk", type="integer")
     */
    private $feedbackFk;

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
     * Get systemInfoTimestamp
     *
     * @return integer
     */
    public function getSystemInfoTimestamp()
    {
        return $this->systemInfoTimestamp;
    }

    /**
     * @param integer $systemInfoTimestamp
     */
    public function setSystemInfoTimestamp($systemInfoTimestamp)
    {
        $this->systemInfoTimestamp = $systemInfoTimestamp;
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

}
