<?php namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AvgTrainingController extends Controller
{

    /**
     * @Route("avgtraining/upload", name="webapi_post_avg_trainings")
     * @Method({"POST"})
     */
    public function postAvgTraining(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $avgTrainingService = $this->get('app.avg.training.service');

        $counter = $avgTrainingService->SaveAvgTrainingData(json_decode($request->getContent(),true), $this->getUser());

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
     * @Route("avgtraining/download", name="webapi_get_all_avg_trainings")
     * @Method({"GET"})
     */
    public function getAvgTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:TrainingAvg');

        $results = $trainingRepo->findBySessionIdRange($request->get('sessionIdFrom'), $request->get('sessionIdTo'), $this->getUser());

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
     * @Route("avgtraining/{sessionid}", name="webapi_get_avg_trainings", requirements={"sessionid": "\d+"})
     * @Method({"GET"})
     */
    public function getAvgTraining($sessionid, Request $request)
    {
        $serializer = $this->get('jms_serializer');

        if(!isset($sessionid) || !$sessionid){
            return new JsonResponse(
                $serializer->serialize(
                    $request,
                    'json'
                ),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:TrainingAvg');

        $results = $trainingRepo->findBy([
            'user'          =>  $this->getUser(),
            'sessionId'     =>  $sessionid
        ]);

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
}