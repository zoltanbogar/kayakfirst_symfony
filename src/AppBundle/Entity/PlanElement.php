<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlanElement
 *
 * @ORM\Table(name="plan_element")
 * @ORM\Entity
 */
class PlanElement
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, nullable=false)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $planElementId;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="intensity", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $intensity;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @var \Plan
     *
     * @ORM\ManyToOne(targetEntity="Plan", inversedBy="planElements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     * })
     */
    private $plan;

    private $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Set planElementId
     *
     * @param string $planElementId
     *
     * @return PlanElement
     */
    public function setPlanElementId($planElementId)
    {
        $this->planElementId = $planElementId;

        return $this;
    }

    /**
     * Get planElementId
     *
     * @return string
     */
    public function getPlanElementId()
    {
        return $this->planElementId;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return PlanElement
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set intensity
     *
     * @param integer $intensity
     *
     * @return PlanElement
     */
    public function setIntensity($intensity)
    {
        $this->intensity = $intensity;

        return $this;
    }

    /**
     * Get intensity
     *
     * @return integer
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return PlanElement
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set plan
     *
     * @param \AppBundle\Entity\Plan $plan
     *
     * @return PlanElement
     */
    public function setPlan(\AppBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

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
}
