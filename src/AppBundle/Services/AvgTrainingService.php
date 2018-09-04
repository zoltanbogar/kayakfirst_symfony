<?php namespace AppBundle\Services;


use AppBundle\Entity\TrainingAvg;
use AppBundle\Entity\User;
use AppBundle\Entity\NewTrainingAvg;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AvgTrainingService
{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function SaveAvgTrainingData($data , User $user)
    {

        $counter = 0;

        foreach ($data as $k => $training){

            $avgTraining = new TrainingAvg();
            $avgTraining->setUser($user);

            if (isset($training['sessionId'])){
                $avgTraining->setSessionId($training['sessionId']);
            } else {
                break;
            }

            if (isset($training['avgType'])){
                $avgTraining->setDataType($training['avgType']);
            } else {
                break;
            }

            if (isset($training['avgValue'])){
                $avgTraining->setDataValue($training['avgValue']);
            } else {
                break;
            }

            $counter++;
            $this->em->persist($avgTraining);
        }

        $this->em->flush();

        return $counter;
    }

    public function SaveNewTrainingAvgData($data , User $user)
    {
        foreach ($data as $k => $training) {
            if (!isset($training['sessionId']) || !isset($training['avgType'])) {
                continue;
            }
            $avg = $this->em->getRepository('AppBundle:NewTrainingAvg')->findOneBy([
                'sessionId' => $training['sessionId'],
                'userId' => $user->getId()
            ]);

            if (null == $avg) {
                $avg = new NewTrainingAvg();
                $avg->sessionId = $training['sessionId'];
                $avg->userId = $user->getId();
                $this->em->persist($avg);
                $this->em->flush();
            }

            if ($training['avgType'] == 'pull_force_av') {
                $avg->force = $training['avgValue'];
            } else if ($training['avgType'] == 'speed_av') {
                $avg->speed = $training['avgValue'];
            } else if ($training['avgType'] == 'strokes_av') {
                $avg->strokes = $training['avgValue'];
            } else if ($training['avgType'] == 't_200_av') {
                $avg->t200 = $training['avgValue'];
            }
            $this->em->persist($avg);
        }
        $this->em->flush();
    }

    public function removeBulk($trainings)
    {
        foreach ($trainings as $k => $training) {
            $this->em->remove($training);
        }

        $this->em->flush();
    }

}
