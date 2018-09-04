<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plan
 *
 * @ORM\Table(name="plan", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Plan
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=180, nullable=false)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $planId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=180, nullable=false)
     * @Assert\Choice(callback = "getTypes")
     * @Assert\NotBlank()
     */
    private $type;

    public function getTypes() {
        return [
            'distance',
            'time'
        ];
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=16777215, nullable=true)
     */
    private $notes;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     * @Exclude
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PlanElement", mappedBy="plan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="plan_id")
     * })
     */
    private $planElements;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="bigint", nullable=true)
     */
    private $sessionId;

    private $length = 0;

    public function getLength()
    {
        return $this->length;
    }

    private $userId;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planElements = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set planId
     *
     * @param string $planId
     *
     * @return Plan
     */
    public function setPlanId($planId)
    {
        $this->planId = $planId;

        return $this;
    }

    /**
     * Get planId
     *
     * @return string
     */
    public function getPlanId()
    {
        return $this->planId;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Plan
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Plan
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Plan
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Plan
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add planElement
     *
     * @param \AppBundle\Entity\PlanElement $planElement
     *
     * @return Plan
     */
    public function addPlanElement(\AppBundle\Entity\PlanElement $planElement)
    {
        $this->planElements[] = $planElement;

        return $this;
    }

    /**
     * Remove planElement
     *
     * @param \AppBundle\Entity\PlanElement $planElement
     */
    public function removePlanElement(\AppBundle\Entity\PlanElement $planElement)
    {
        $this->planElements->removeElement($planElement);
    }

    /**
     * Get planElements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanElements()
    {
        return $this->planElements;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return PlanTraining
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get notes
     *
     * @return integer
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @ORM\PostLoad
     */
    public function updateSelf()
    {
        $this->length = 0;

        foreach ($this->planElements as $planElement) {
            $this->length += $planElement->getValue();

            $planElement->setType($this->type);
        }

        $this->userId = null;

        if ($this->getUser()) {
            $this->userId = $this->getUser()->getId();
        }
    }
}
