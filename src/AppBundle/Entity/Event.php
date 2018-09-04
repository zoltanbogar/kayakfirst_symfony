<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event", uniqueConstraints={@ORM\UniqueConstraint(name="event_id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_user_idx", columns={"user_id"}), @ORM\Index(name="fk_event_plan_idx", columns={"plan_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=180, nullable=false)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $eventId;

    /**
     * @var integer
     *
     * @ORM\Column(name="session_id", type="bigint", nullable=false)
     * @Assert\NotBlank()
     */
    private $sessionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="bigint", nullable=false)
     * @Assert\NotBlank()
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_type", type="string", length=180, nullable=false)
     * @Assert\Choice(callback = "getTypes")
     * @Assert\NotBlank()
     */
    private $planType;

    public function getPlanTypes() {
        return [
            'distance',
            'time'
        ];
    }

    /**
     * @var \Plan
     *
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     * })
     * @Exclude
     */
    private $plan;

    private $planId;

    private $userId;

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
     * Get id
     *
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Set sessionId
     *
     * @param integer $sessionId
     *
     * @return Event
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return integer
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     *
     * @return Event
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Event
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
     * Set planType
     *
     * @param string $planType
     *
     * @return Event
     */
    public function setPlanType($planType)
    {
        $this->planType = $planType;

        return $this;
    }

    /**
     * Get planType
     *
     * @return string
     */
    public function getPlanType()
    {
        return $this->planType;
    }

    /**
     * Set plan
     *
     * @param \AppBundle\Entity\Plan $plan
     *
     * @return Event
     */
    public function setPlan(\AppBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

        if ($plan) {
            $this->planId = $plan->getPlanId();
        } else {
            $this->planId = null;
        }

        return $this;
    }

    /**
     * Get plan
     *
     * @return \AppBundle\Entity\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Event
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
     * @ORM\PostLoad
     */
    public function updateSelf()
    {
        $this->planId = null;
        $this->userId = null;

        if ($this->getPlan()) {
            $this->planId = $this->getPlan()->getPlanId();
        }

        if ($this->getUser()) {
            $this->userId = $this->getUser()->getId();
        }
    }
}
