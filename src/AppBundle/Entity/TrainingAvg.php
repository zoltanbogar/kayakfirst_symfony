<?php namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

/**
 * Training
 *
 * @ORM\Table(name="trainingAvg", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingAvgRepository")
 * @ExclusionPolicy("all")
 *
 */
class TrainingAvg
{
    /**
     * @ORM\Column(name="id", type="integer")
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="avgTrainings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="data_type", type="string")
     * @Assert\Choice(callback = "getDataTypes")
     * @Assert\NotBlank()
     * @Expose
     */
    protected $dataType;

    /**
     * @ORM\Column(name="data_value", type="float")
     * @Assert\NotBlank()
     * @Expose
     */
    protected $dataValue;

    public function getDataTypes(){
        return [
            'average_t_200',
            'average_t_500',
            'average_t_1000',
            'average_strokes',
            'average_pull_force',
            'sum_distance'
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param mixed $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return mixed
     */
    public function getDataValue()
    {
        return $this->dataValue;
    }

    /**
     * @param mixed $dataValue
     */
    public function setDataValue($dataValue)
    {
        $this->dataValue = $dataValue;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
