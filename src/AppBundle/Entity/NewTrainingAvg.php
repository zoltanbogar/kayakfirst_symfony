<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewTrainingAvg
 *
 * @ORM\Table(name="newTrainingAvg")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewTrainingAvgRepository")
 */
class NewTrainingAvg
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
     * @var float
     *
     * @ORM\Column(name="_force", type="float")
     */
    public $force;

    /**
     * @var float
     *
     * @ORM\Column(name="speed", type="float")
     */
    public $speed;

    /**
     * @var float
     *
     * @ORM\Column(name="strokes", type="float")
     */
    public $strokes;

    /**
     * @var float
     *
     * @ORM\Column(name="t_200", type="float")
     */
    public $t200;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    public $userId;

}
