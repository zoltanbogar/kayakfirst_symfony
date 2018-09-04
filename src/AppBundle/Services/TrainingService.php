<?php namespace AppBundle\Services;

use AppBundle\Entity\Training;
use AppBundle\Entity\User;
use AppBundle\Entity\SumTraining;
use AppBundle\Entity\NewTraining;
use AppBundle\Entity\Plan;
use AppBundle\Repository\NewTrainingRepository;
use AppBundle\Repository\SumTrainingRepository;
use AppBundle\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

class TrainingService
{

    protected $sessions = [];
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var SumTrainingRepository
     */
    private $repo;

    public function __construct(EntityManager $entityManager/*, ValidatorInterface $validator*/)
    {
        $this->em = $entityManager;
        //$this->validator = $validator;
        //$this->userRepo = $this->em->getRepository('AppBundle:User');
        $this->repo = $entityManager->getRepository('AppBundle:SumTraining');
    }

    public function SaveTrainingData($data, User $user)
    {
        $counter = 0;

        foreach ($data as $trainingData) {
            if (!isset($trainingData['sessionId'])) continue;

            $arrayData = [
                'timestamp' => isset($trainingData['timestamp']) ? $trainingData['timestamp'] : '',
                'dataType' => isset($trainingData['dataType']) ? $trainingData['dataType'] : '',
                'dataValue' => isset($trainingData['dataValue']) ? $trainingData['dataValue'] : '',
                'currentDistance' => isset($trainingData['currentDistance']) ? $trainingData['currentDistance'] : ''
            ];

            $training = $this->em->getRepository('AppBundle:Training')->findOneBy([
                'user' => $user,
                'sessionId' => $trainingData['sessionId']
            ]);

            if ($training == null) {
                $training = new Training();

                $training->setUser($user);

                if (isset($trainingData['sessionId'])) {
                    $training->setSessionId($trainingData['sessionId']);
                }
            } /* elseif ($training->getHash() == $this->hashGenerator($user->getId(), $training->getSessionId(), [ $arrayData ])) {
                continue;
            } */

            if (isset($trainingData['trainingType'])) {
                $training->setTrainingType($trainingData['trainingType']);
            }

            if (isset($trainingData['trainingEnvironmentType'])) {
                $training->setTrainingEnvironmentType($trainingData['trainingEnvironmentType']);
            }

            $training->addData($arrayData);

            $training->setHash($this->hashGenerator($user->getId(), $training->getSessionId(), $training->getData()));

            $this->em->persist($training);

            $counter++;
        }

        $this->em->flush();

        return $counter;
    }

    public function SaveNewTrainingDataWithSum($data, User $user) {
        $hashmap = array();

try {
$this->em->getConnection()->beginTransaction();
// --------------------------------------------

        foreach ($data as $trainingData) {
            if (!isset($trainingData['sessionId']) || !isset($trainingData['currentDistance'])) {
                continue;
            }

            $entity = $this->em->getRepository('AppBundle:NewTraining')->findOneBy([
                'userId' => $user->getId(),
                'sessionId' => $trainingData['sessionId'],
                'oldVersionSwitch' => $trainingData['currentDistance']
            ]);
            if (null == $entity) {
                $entity = new NewTraining();
                $entity->sessionId = $trainingData['sessionId'];
                $entity->timestamp = $trainingData['timestamp'];
                $entity->oldVersionSwitch = $trainingData['currentDistance'];
                $entity->userId = $user->getId();

                $this->em->persist($entity);
                $this->em->flush();
            }

            if ($trainingData['dataType'] == 'pull_force') {
                $entity->force = $trainingData['dataValue'];
            } else if ($trainingData['dataType'] == 'speed') {
                $entity->speed = $trainingData['dataValue'];
            } else if ($trainingData['dataType'] == 'currant_distance') {
                $entity->distance = $trainingData['dataValue'];
            } else if ($trainingData['dataType'] == 'strokes') {
                $entity->strokes = $trainingData['dataValue'];
            } else if ($trainingData['dataType'] == 't_200') {
                $entity->t200 = $trainingData['dataValue'];
            }

            if ($trainingData['timestamp'] < $entity->timestamp) {
                $entity->timestamp = $trainingData['timestamp'];
            }
            $this->em->persist($entity);
            $this->em->flush();

            $val = ['sessionId' => $trainingData['sessionId'], 'trainingEnvironmentType' => $trainingData['trainingEnvironmentType']];
            if (!in_array($val, $hashmap)) {
                array_push($hashmap, $val);
            }
        }

        foreach ($hashmap as $entry) {
            $st = $this->repo->findOneBy([
                'userId' => $user->getId(),
                'sessionId' => $entry['sessionId']
            ]);

            if (null == $st) {
                $st = new SumTraining();
                $st->userId = $user->getId();
                $st->sessionId = $entry['sessionId'];
                $st->artOfPaddle = 'racing_kayaking';
                $st->trainingEnvironmentType = $entry['trainingEnvironmentType'];
            }

            $data = $this->em
                ->createQuery("select count(1), min(nt.timestamp), max(nt.timestamp)-min(nt.timestamp), max(nt.distance) from AppBundle\Entity\NewTraining nt where nt.sessionId in (?1)")
                ->setParameter(1, $entry['sessionId'])
                ->getResult();
            $st->trainingCount = $data[0][1];
            $st->startTime = $data[0][2];
            $st->duration = $data[0][3];
            $st->distance = $data[0][4];

            $plan = $this->em->getRepository('AppBundle:Plan')->findOneBy([
                'user' => $user,
                'sessionId' => $entry['sessionId']
            ]);
            if (null != $plan) {
                $st->planTrainingId = $plan->getPlanId();
                $st->planTrainingType = $plan->getType();
            }

            $this->em->persist($st);
        }
        $this->em->flush();

// ----------------------------------
$this->em->getConnection()->commit();
} catch (Exception $e) {
$this->em->getConnection()->rollBack();
}
    }

    protected function hashGenerator($userId, $sessionId, $arrayData)
    {
        $collection = new ArrayCollection($arrayData);

        $first = $collection->first();

        $last = $collection->last();

        $hash = "";
        $hash .= $userId;
        $hash .= $sessionId;
        $hash .= isset($first['dataType']) ? $first['dataType'] : '';
        $hash .= isset($first['dataValue']) ? $first['dataValue'] : '';
        $hash .= isset($first['timestamp']) ? $first['timestamp'] : '';
        $hash .= isset($last['dataType']) ? $last['dataType'] : '';
        $hash .= isset($last['dataValue']) ? $last['dataValue'] : '';
        $hash .= isset($last['timestamp']) ? $last['timestamp'] : '';

        return md5($hash);
    }

    public function removeBulk($trainings, $trainingAvgs, $plans, $sumTrainings, $newTrainings, $newTrainingAvgs)
    {
        $count = 0;
        $em = $this->em;
        try {
        $em->getConnection()->beginTransaction();

        foreach ($trainings as $k => $training) {
            $em->remove($training);
        }
        foreach ($trainingAvgs as $k => $trainingAvg) {
            $em->remove($trainingAvg);
        }
        foreach ($sumTrainings as $k => $st) {
            $em->remove($st);
        }
$em->flush();
        foreach ($plans as $k => $plan) {
            $em->remove($plan);
        }
        foreach ($newTrainings as $k => $nt) {
            $em->remove($nt);
        }
        foreach ($newTrainingAvgs as $k => $nta) {
            $em->remove($nta);
        }

        $em->flush();
        $em->getConnection()->commit();
        $count = count($trainings) + count($trainingAvgs) + count($plans) + count($sumTrainings) + count($newTrainings) + count($newTrainingAvgs);
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
        }
        return $count;
    }

}
