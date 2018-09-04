<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewTraining
 *
 * @ORM\Table(name="newTraining")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewTrainingRepository")
 */
class NewTraining
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    public $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="session_id", type="bigint")
     */
    public $sessionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="bigint")
     */
    public $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="_force", type="bigint")
     */
    public $force;

    /**
     * @var integer
     *
     * @ORM\Column(name="speed", type="bigint")
     */
    public $speed;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="bigint")
     */
    public $distance;

    /**
     * @var integer
     *
     * @ORM\Column(name="strokes", type="bigint")
     */
    public $strokes;

    /**
     * @var integer
     *
     * @ORM\Column(name="t_200", type="bigint")
     */
    public $t200;

    /**
     * @var float
     *
     * @ORM\Column(name="old_version_switch", type="float")
     */
    public $oldVersionSwitch;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    public $userId;

}
