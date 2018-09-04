<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\NewTraining;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewTrainingController extends Controller
{

    /**
     * @Route("/training/uploadTrainings", name="api_upload_trainings")
     * @Method({"POST"})
     */
    public function uploadTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:NewTraining');
        $map = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getEntityManager();
        $count = 0;
        try {
            $em->getConnection()->beginTransaction();

            foreach ($map as &$value) {
                $nt = new NewTraining();
                $nt->sessionId = $value['sessionId'];
                $nt->timestamp = $value['timestamp'];
                $nt->force = $value['force'];
                $nt->speed = $value['speed'];
                $nt->distance = $value['distance'];
                $nt->strokes = $value['strokes'];
                $nt->t200 = $value['t200'];
                $nt->userId = $this->getUser()->getId();
                $em->persist($nt);
            }
            $em->flush();

            $em->getConnection()->commit();
            $count = count($map);
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
        }

        return new JsonResponse(
            $serializer->serialize(['inserted' => $count], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/training/downloadBySessionIds", name="api_download_by_session_ids")
     * @Method({"POST"})
     */
    public function downloadBySessionIds(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:NewTraining');
        $map = json_decode($request->getContent(), true);

        $array = $repo->findBySessionIds($map, $this->getUser()->getId());
        return new JsonResponse(
            $serializer->serialize($array, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/training/downloadDays", name="api_download_days")
     * @Method({"POST"})
     */
    public function downloadDays(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $param = json_decode($request->getContent(), true);

        $trainingRepo = $this->getDoctrine()->getRepository('AppBundle:SumTraining');

        $days = $trainingRepo->findBySessionIdRange($param['timestampFrom'], $param['timestampTo'], $this->getUser());

        $sessionIds = [];

        foreach ($days as $k => $session) {
            $sessionIds[] = $session->sessionId;
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

}
