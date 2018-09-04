<?php namespace AppBundle\Services;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class EventService
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

        foreach ($data as $objData) {
            $obj = new Event();

            $obj->setUser($user);

            if (isset($objData['eventId'])) {
                $obj->setEventId($objData['eventId']);
            }

            if (isset($objData['sessionId'])) {
                $obj->setSessionId($objData['sessionId']);
            }

            if (isset($objData['timestamp'])) {
                $obj->setTimestamp($objData['timestamp']);
            }

            if (isset($objData['name'])) {
                $obj->setName($objData['name']);
            }

            if (isset($objData['planType'])) {
                $obj->setPlanType($objData['planType']);
            }

            if (isset($objData['planId'])) {
                $plan = $this->em->getRepository('AppBundle:Plan')->findOneBy([
                    'user' => $user,
                    'planId' => $objData['planId']
                ]);

                $obj->setPlan($plan);
            }

            $this->em->persist($obj);
            $counter++;
        }

        $this->em->flush();

        return $counter;
    }

    public function editData($objData, $user)
    {
        $obj = $this->em->getRepository('AppBundle:Event')->findOneBy([
            'user' => $user,
            'eventId' => $objData['eventId']
        ]);

        if (!$obj) return null;

        if (isset($objData['sessionId'])) {
            $obj->setSessionId($objData['sessionId']);
        }

        if (isset($objData['timestamp'])) {
            $obj->setTimestamp($objData['timestamp']);
        }

        if (isset($objData['name'])) {
            $obj->setName($objData['name']);
        }

        if (isset($objData['planType'])) {
            $obj->setPlanType($objData['planType']);
        }

        if (isset($objData['planId'])) {
            $plan = $this->em->getRepository('AppBundle:Plan')->findOneBy([
                'user' => $user,
                'planId' => $objData['planId']
            ]);

            $obj->setPlan($plan);
        }

        $this->em->flush();

        return $obj;
    }

    public function removeBulk($objects)
    {
        foreach ($objects as $object) {
            $this->em->remove($object);
        }

        $this->em->flush();
    }

}
