<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SumTraining
 *
 * @ORM\Table(name="sumTraining")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SumTrainingRepository")
 */
class SumTraining
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
     * @ORM\Column(name="user_id", type="integer")
     */
    public $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="art_of_paddle", type="string")
     */
    public $artOfPaddle;

    /**
     * @var string
     *
     * @ORM\Column(name="training_environment_type", type="string")
     */
    public $trainingEnvironmentType;

    /**
     * @var integer
     *
     * @ORM\Column(name="training_count", type="integer")
     */
    public $trainingCount;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_training_id", type="string", length=180)
     */
    public $planTrainingId;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_training_type", type="string", length=255)
     */
    public $planTrainingType;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_time", type="integer")
     */
    public $startTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    public $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="integer")
     */
    public $distance;

}
