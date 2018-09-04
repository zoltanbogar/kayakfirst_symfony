<?php namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

/**
 * Training
 *
 * @ORM\Table(name="training", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingRepository")
 * @ExclusionPolicy("all")
 * @UniqueEntity("hash")
 *
 */
class Training
{

    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(name="session_id", type="bigint")
     * @Assert\NotBlank()
     * @Expose
     * @SerializedName("sessionId")
     */
    protected $sessionId;

    /**
     * @ORM\Column(name="training_type", type="string")
     * @Assert\Choice(callback = "getTrainingTypes")
     * @Assert\NotBlank()
     * @Expose
     * @SerializedName("trainingType")
     */
    protected $trainingType;

    /**
     * @ORM\Column(name="training_env_type", type="string")
     * @Assert\Choice(callback = "getTrainingEnvTypes")
     * @Assert\NotBlank()
     * @Expose
     * @SerializedName("trainingEnvironmentType")
     */
    protected $trainingEnvironmentType = 'ergometer';

    /**
     * @ORM\Column(name="data", type="array")
     * @Assert\NotBlank()
     * @Expose
     */
    protected $data;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="trainings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="hash", type="string")
     * @var
     */
    protected $hash;

    public function __construct()
    {
        $this->data = [];
    }

    public static function getTrainingTypes(){
        return [
            'kayak',
            'canoe',
            'dragon boat'
        ];
    }

    public static function getTrainingEnvTypes(){
        return [
            'ergometer',
            'outdoor'
        ];
    }

    public function getDataTypes(){
        return [
            't_200',
            't_500',
            't_1000',
            'strokes',
            'pull_force',
            'currant_distance',
            'actual_speed'
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param int $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getTrainingType()
    {
        return $this->trainingType;
    }

    /**
     * @param string $trainingType
     */
    public function setTrainingType($trainingType)
    {
        $this->trainingType = $trainingType;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function addData($data)
    {
        $this->data[] = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getTrainingEnvironmentType()
    {
        return $this->trainingEnvironmentType;
    }

    /**
     * @param mixed $trainingEnvironmentType
     */
    public function setTrainingEnvironmentType($trainingEnvironmentType)
    {
        $this->trainingEnvironmentType = $trainingEnvironmentType;
    }
}
