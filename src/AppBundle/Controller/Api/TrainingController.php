<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\Training;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends Controller
{

    /**
     * @Route("training/download", name="api_get_trainings")
     * @Method({"POST"})
     */
    public function getTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:Training');

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
     * @Route("training/upload", name="api_post_trainings")
     * @Method({"POST"})
     */
    public function postTrainings(Request $request)
    {

        $serializer = $this->get('jms_serializer');

        $trainingService = $this->get('app.training.service');

        #$counter = $trainingService->SaveTrainingData(json_decode($request->getContent(),true), $this->getUser());
        $counter = $trainingService->SaveTrainingData($request->request->all(), $this->getUser());
        $trainingService->SaveNewTrainingDataWithSum($request->request->all(), $this->getUser());

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
     * @Route("training/days", name="api_get_training_days")
     * @Method({"GET"})
     */
    public function getTrainingDays()
    {
        $serializer = $this->get('jms_serializer');

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:Training');

        $days = $trainingRepo->findTrainingDaysByUser($this->getUser());

        $sessionIds = [];

        foreach ($days as $k => $session) {
            $sessionIds[] = $session['sessionId'];
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

    /**
     * @Route("training/delete", name="api_delete_training")
     * @Method({"POST"})
     */
    public function delete(Request $request)
    {
        // $param = $request->request->all();
        $param = json_decode($request->getContent(), true);

        $dataLen = 0;

        if (isset($param)) {
            $user = $this->getUser();

            $repo1 = $this->getDoctrine()->getRepository('AppBundle:Training');
            $repo2 = $this->getDoctrine()->getRepository('AppBundle:TrainingAvg');
            $repo3 = $this->getDoctrine()->getRepository('AppBundle:Plan');
            $repo4 = $this->getDoctrine()->getRepository('AppBundle:SumTraining');
            $repo5 = $this->getDoctrine()->getRepository('AppBundle:NewTraining');
            $repo6 = $this->getDoctrine()->getRepository('AppBundle:NewTrainingAvg');

            $data1 = $repo1->findBySessionIdsAndUser(
                $param,
                $user
            );
            $data2 = $repo2->findBySessionIdsAndUser(
                $param,
                $user
            );
            $data3 = $repo3->findBySessionIdsAndUser(
                $param,
                $user
            );
            $data4 = $repo4->findBySessionIdsAndUser(
                $param,
                $user
            );
            $data5 = $repo5->findBySessionIds(
                $param,
                $user->getId()
            );
            $data6 = $repo6->findBySessionIds(
                $param,
                $user->getId()
            );

            $dataLen = $this->get('app.training.service')->removeBulk($data1, $data2, $data3, $data4, $data5, $data6);
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize(
                ['deleted' => $dataLen],
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

        foreach ($errors as $k => $error){
            $data[$error->getPropertyPath()] = $error->getMessage();
        }

        return $data;
    }

}
