<?php namespace AppBundle\Services;

use AppBundle\Entity\PlanElement;
use AppBundle\Entity\Plan;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class PlanService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function saveData($data, $user)
    {
        $counter = 0;

        foreach ($data as $planData) {
            if (!isset($planData['planId'])) continue;

            $plan = new Plan();

            $plan->setUser($user);

            $plan->setPlanId($planData['planId']);

            if (isset($planData['type'])) {
                $plan->setType($planData['type']);
            }

            if (isset($planData['name'])) {
                $plan->setName($planData['name']);
            }

            if (isset($planData['notes'])) {
                $plan->setNotes($planData['notes']);
            }

            if (isset($planData['planElements'])) {
                foreach ($planData['planElements'] as $planElementData) {
                    $planElement = new PlanElement();

                    $planElement->setPlan($plan);
                    $planElement->setPlanElementId($planElementData['planElementId']);
                    $planElement->setPosition($planElementData['position']);
                    $planElement->setIntensity($planElementData['intensity']);
                    $planElement->setValue($planElementData['value']);

                    $plan->addPlanElement($planElement);

                    $this->em->persist($planElement);
                }
            }

            $this->em->persist($plan);
            $counter++;
        }

        $this->em->flush();

        return $counter;
    }

    public function editData($planData, $user)
    {
        $plan = $this->em->getRepository('AppBundle:Plan')->findOneBy([
            'sessionId' => null,
            'user' => $user,
            'planId' => $planData['planId']
        ]);

        if ($plan == null) return null;

        if (isset($planData['type'])) {
            $plan->setType($planData['type']);
        }

        if (isset($planData['name'])) {
            $plan->setName($planData['name']);
        }

        if (isset($planData['notes'])) {
            $plan->setNotes($planData['notes']);
        }

        $toRemove = [];

        foreach ($plan->getPlanElements() as $planElement) {
            $toRemove[$planElement->getPlanElementId()] = $planElement;
        }

        if ($planData['planElements']) {
            foreach ($planData['planElements'] as $planElementData) {
                $planElement = null;

                if (isset($toRemove[$planElementData['planElementId']])) {
                    $planElement = $toRemove[$planElementData['planElementId']];
                } else {
                    $planElement = new PlanElement();
                }

                $planElement->setPlan($plan);

                if (!$planElement->getPlanElementId()) {
                    $planElement->setPlanElementId($planElementData['planElementId']);
                }

                $planElement->setPosition($planElementData['position']);
                $planElement->setIntensity($planElementData['intensity']);
                $planElement->setValue($planElementData['value']);

                if (isset($toRemove[$planElementData['planElementId']])) {
                    unset($toRemove[$planElementData['planElementId']]);
                } else {
                    $plan->addPlanElement($planElement);
                }

                $this->em->persist($planElement);
            }
        }

        foreach ($toRemove as $planElement) {
            $plan->removePlanElement($planElement);

            $planElement->setPlan(null);

            $this->em->remove($planElement);
        }

        $this->em->persist($plan);

        $this->em->flush();

        return $plan;
    }

    public function removeBulk($objects)
    {
        foreach ($objects as $object) {
            $this->em->remove($object);
        }

        $this->em->flush();
    }

}
