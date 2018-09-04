<?php namespace AppBundle\Controller\Api;

// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\SumTraining;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SumTrainingController extends Controller
{

    /**
     * @Route("/training/uploadSumTrainings", name="api_upload_sum_trainings")
     * @Method({"POST"})
     */
    public function uploadSumTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:SumTraining');
        $map = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getEntityManager();
        $count = 0;

        $logger = $this->get('logger');
        $logger->info('SUMTRAINING_REQ', $request);
        $logger->info('SUMTRAINING_MAP', $map);

        try {
            $em->getConnection()->beginTransaction();

            foreach ($map as &$value) {
                $st = new SumTraining();
                $st->sessionId = $value['sessionId'];
                $st->userId = $this->getUser()->getId();
                $st->artOfPaddle = $value['artOfPaddle'];
                $st->trainingEnvironmentType = $value['trainingEnvironmentType'];
                $st->trainingCount = $value['trainingCount'];
                if ('' == $value['planTrainingId']) {
                    $st->planTrainingId = null;
                } else {
                    $st->planTrainingId = $value['planTrainingId'];
                }
                if ('' == $value['planTrainingType']) {
                    $st->planTrainingType = null;
                } else {
                    $st->planTrainingType = $value['planTrainingType'];
                }
                $st->startTime = $value['startTime'];
                $st->duration = $value['duration'];
                $st->distance = $value['distance'];
                $em->persist($st);
            }
            $em->flush();

            // $error = 'Always throw this error';
            // throw new NotFoundHttpException($error);

            $em->getConnection()->commit();
            $count = count($map);
        } catch (Exception $e) {
            $logger->info('SUMTRAINING EXCEPTION!!!!');
            $em->getConnection()->rollBack();
            $count = 0;
            throw $e;
        }

        return new JsonResponse(
            $serializer->serialize(['inserted' => $count], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/training/downloadSumTrainings", name="api_download_sum_trainings")
     * @Method({"POST"})
     */
    public function downloadSumTrainings(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:SumTraining');
        $map = json_decode($request->getContent(), true);

        $array = $repo->findByDummy($map, $this->getUser()->getId()); // [1519240889000]
        // print_r($array);

        return new JsonResponse(
            $serializer->serialize($array, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

}
