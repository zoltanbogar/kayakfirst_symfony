<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\Plan;
use AppBundle\Entity\PlanElement;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanTrainingController extends Controller
{

    /**
     * @Route("planTraining/downloadBySessionId", name="api_get_plantrainings_by_sessionid")
     * @Method({"POST"})
     */
    public function downloadBySessionId(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Plan');

        $results = $repo->findBySessionIdRange(
            $this->getUser(),
            $request->get('sessionIdFrom'),
            $request->get('sessionIdTo')
        );

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($results, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("planTraining/downloadBySessionIds", name="api_get_plantrainings_by_sessionids")
     * @Method({"POST"})
     */
    public function downloadBySessionIds(Request $request)
    {
        $list = json_decode($request->getContent(), true);
        $repo = $this->getDoctrine()->getRepository('AppBundle:Plan');

        $qb = $repo->createQueryBuilder('t')
            ->select('t')
            ->where('t.sessionId in (:list)')
            ->andWhere('t.user = :user')
            ->setParameter(':list', $list)
            ->setParameter(':user', $this->getUser());
        $result = $qb->getQuery()->getResult();

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($result, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("planTraining/upload", name="api_post_plantrainings")
     * @Method({"POST"})
     */
    public function upload(Request $request)
    {
        $counter = $this->get('app.plan_training.service')->saveData($request->request->all(), $this->getUser());

        return new JsonResponse(
            $this->get('jms_serializer')->serialize([ 'inserted' => $counter ], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("planTraining/delete", name="api_delete_plantraining")
     * @Method({"POST"})
     */
    public function delete(Request $request)
    {
        $param = $request->request->all();

        $dataLen = 0;

        if (isset($param)) {
            $user = $this->getUser();

            $repo = $this->getDoctrine()->getRepository('AppBundle:Plan');

            $data = $repo->findBy([
                'user' => $user,
                'planId' => $param
            ]);

            $dataLen = count($data);

            $this->get('app.plan_training.service')->removeBulk($data);
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize([ 'deleted' => $dataLen ], 'json'),
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
