<?php namespace AppBundle\Controller\Web;

use AppBundle\Entity\Training;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends Controller
{

    /**
     * @Route("training/downloadavg", name="webapi_get_training_avgs")
     */
    public function getTrainingAvgs(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:SumTraining');
        $trainingAvgRepo = $this->getDoctrine()->getRepository('AppBundle:NewTrainingAvg');
        /* $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:Training');
        $trainingAvgRepo = $this->getDoctrine()->getRepository('AppBundle:TrainingAvg'); */
        $sessionIdFrom = $request->get('sessionIdFrom');
        $sessionIdTo = $request->get('sessionIdTo');

        if ($request->get('selectedDate')) {
            $selectedDate = new \DateTime($request->get('selectedDate') . ' 00:00:00');
            $nextDay = new \DateTime($request->get('selectedDate') . ' 23:59:59');

            $sessionIdFrom = $selectedDate->getTimestamp() * 1000;
            $sessionIdTo = $nextDay->getTimestamp() * 1000;
        }

        $results = $trainingRepo->findBySessionIdRange($sessionIdFrom, $sessionIdTo, $this->getUser()->getId(), Query::HYDRATE_ARRAY);
        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:NewTraining');
        $res = array();

        foreach ($results as $r) {
            $data = $trainingRepo->findBySessionIds([$r['sessionId']], $this->getUser()->getId());
            if (isset($res[$r['sessionId']])) {
                // $res[$r['sessionId']]['data'] = array_merge($res[$r['sessionId']]['data'], $r['data']);
                throw new \Exception('Distinct operation should be used!');
            }
            else {
                $res[$r['sessionId']] = array(
                    'trainingType' => $r['artOfPaddle'], // $r['trainingType']
                    'trainingEnvironmentType' => $r['trainingEnvironmentType'],
                    'data' => $this->convertToOldSchema($data), // $r['data']
                    'startTime' => $r['startTime'], // $r['data'][0]['timestamp']
                    'endTime' => 0,
                );
            }
            // $first = $res[$r['sessionId']]['data'][0]['timestamp'];
            $last = $res[$r['sessionId']]['data'][count($res[$r['sessionId']]['data']) - 1]['timestamp'];
            /* if ($res[$r['sessionId']]['startTime'] > $first) {
                $res[$r['sessionId']]['startTime'] = $first;
            } */
            if ($res[$r['sessionId']]['endTime'] < $last) {
                $res[$r['sessionId']]['endTime'] = $last;
            }
        }

        $resultsAvg = $trainingAvgRepo->findBySessionIdRange($sessionIdFrom, $sessionIdTo, $this->getUser()->getId(), Query::HYDRATE_ARRAY);
        foreach ($resultsAvg as $ra) {
            if (isset($res[$ra['sessionId']])) {
                // $res[$ra['sessionId']][$ra['dataType']] = round($ra['dataValue'], 1);
                if (null != $ra['force']) {
                    $res[$ra['sessionId']]['pull_force_av'] = round($ra['force'], 1);
                } else {
                    $res[$ra['sessionId']]['pull_force_av'] = 0;
                }
                if (null != $ra['speed']) {
                    $res[$ra['sessionId']]['speed_av'] = round($ra['speed'], 1);
                } else {
                    $res[$ra['sessionId']]['speed_av'] = 0;
                }
                if (null != $ra['strokes']) {
                    $res[$ra['sessionId']]['strokes_av'] = round($ra['strokes'], 1);
                } else {
                    $res[$ra['sessionId']]['strokes_av'] = 0;
                }
                if (null != $ra['t200']) {
                    $res[$ra['sessionId']]['t_200_av'] = round($ra['t200'], 1);
                    $t100 = $ra['t200'] / 2.0;
                    $res[$ra['sessionId']]['t_500_av'] = round($t100 * 5.0, 1);
                    $res[$ra['sessionId']]['t_1000_av'] = round($t100 * 10.0, 1);
                } else {
                    $res[$ra['sessionId']]['t_200_av'] = 0;
                    $res[$ra['sessionId']]['t_500_av'] = 0;
                    $res[$ra['sessionId']]['t_1000_av'] = 0;
                }
            }
        }

        foreach ($res as $sessionId => $r) {
            if (isset($res[$sessionId]['data'])) {
                $best = self::getBest($res[$sessionId]['data']);
                foreach ($best as $bk => $bv) {
                    $res[$sessionId][$bk] = ($bk == 'speed_best') ? round($bv, 1) : round($bv);
                }
            }
        }

        return new JsonResponse(
            $serializer->serialize(
                $res
                ,'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    protected function convertToOldSchema($trainings) {
        $retval = array();
        foreach ($trainings as $data) {
            if (null != $data->force) {
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 'pull_force',
                    'dataValue' => $data->force, // + 0
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
            }
            if (null != $data->speed) {
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 'speed',
                    'dataValue' => $data->speed,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
            }
            if (null != $data->distance) {
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 'currant_distance',
                    'dataValue' => $data->distance,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
            }
            if (null != $data->strokes) {
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 'strokes',
                    'dataValue' => $data->strokes,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
            }
            if (null != $data->t200) {
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 't_200',
                    'dataValue' => $data->t200,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
                $t100 = $data->t200 / 2.0;
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 't_500',
                    'dataValue' => $t100 * 5.0,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
                $temp = [
                    'timestamp' => $data->timestamp,
                    'dataType' => 't_1000',
                    'dataValue' => $t100 * 10.0,
                    'currentDistance' => 0
                ];
                array_push($retval, $temp);
            }
        }

        return $retval;
    }

    /**
     * @Route("training/download", name="webapi_get_trainings")
     * @Method({"POST"})
     */
    public function getTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:Training');
        $sessionIdFrom = $request->get('sessionIdFrom');
        $sessionIdTo = $request->get('sessionIdTo');

        if ($request->get('selectedDate')) {
            $sessionIdFrom = strtotime($request->get('selectedDate') . ' 00:00:00') * 1000;
            $sessionIdTo = strtotime($request->get('sessionIdTo') . ' 23:59:59') * 1000;
        }

        $results = $trainingRepo->findBySessionIdRange($sessionIdFrom, $sessionIdTo, $this->getUser());

        return new JsonResponse(
            $serializer->serialize(
                $results,
                'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("training/upload", name="webapi_post_trainings")
     * @Method({"POST"})
     */
    public function postTrainings(Request $request)
    {

        //TODO: Validation

        $serializer = $this->get('jms_serializer');

        $trainingServie = $this->get('app.training.service');

        $counter = $trainingServie->SaveTrainingData(json_decode($request->getContent(), true), $this->getUser());

        return new JsonResponse(
            $serializer->serialize(
                ['inserted' => $counter],
                'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("training/days", name="webapi_get_training_days")
     * @Method({"GET"})
     */
    public function getTrainingDays()
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:SumTraining');

        $days = $trainingRepo->findTrainingDaysByUser($this->getUser()->getId());

        $sessionIds = [];

        foreach ($days as $k => $session) {
            $d = date("Y-m-d", substr($session['sessionId'], 0, strlen($session['sessionId']) - 3));
            if (!in_array($d, $sessionIds)) {
                $sessionIds[] = $d;
            }
        }

        return new JsonResponse(
            $serializer->serialize(
                $sessionIds,
                'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }

    protected function errorConverter($errors)
    {
        $data = [];

        foreach ($errors as $k => $error) {
            $data[$error->getPropertyPath()] = $error->getMessage();
        }

        return $data;
    }

    static public function getBest($array)
    {
        $best = array();
        foreach ($array as $k => $v) {
            if ($v['dataValue'] > 0 && in_array($v['dataType'], array('t_1000', 't_500', 't_200'))) {
                if (!isset($best[$v['dataType'] . '_best'])) {
                    $best[$v['dataType'] . '_best'] = $v['dataValue'];
                }
                $best[$v['dataType'] . '_best'] = min(array($best[$v['dataType'] . '_best'], $v['dataValue']));

            }

            if (in_array($v['dataType'], array('speed', 'strokes', 'pull_force', 'currant_distance'))) {
                if (!isset($best[$v['dataType'] . '_best'])) {
                    $best[$v['dataType'] . '_best'] = $v['dataValue'];
                }
                $best[$v['dataType'] . '_best'] = max(array($best[$v['dataType'] . '_best'], $v['dataValue']));
            }
        }

        return $best;

    }

}
