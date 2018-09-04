<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\NewTrainingAvg;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewTrainingAvgController extends Controller
{

    /**
     * @Route("/avgtraining/uploadAvgTrainings", name="api_upload_avg_trainings")
     * @Method({"POST"})
     */
    public function uploadAvgTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:NewTrainingAvg');
        $map = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getEntityManager();
        $count = 0;
        try {
            $em->getConnection()->beginTransaction();

            foreach ($map as &$value) {
                $nt = new NewTrainingAvg();
                $nt->sessionId = $value['sessionId'];
                $nt->force = $value['force'];
                $nt->speed = $value['speed'];
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
     * @Route("/avgtraining/downloadBySessionIds", name="api_download_avg_by_session_ids")
     * @Method({"POST"})
     */
    public function downloadBySessionIds(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:NewTrainingAvg');
        $map = json_decode($request->getContent(), true);

        $array = $repo->findBySessionIds($map, $this->getUser()->getId());
        return new JsonResponse(
            $serializer->serialize($array, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

}
