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

class PlanController extends Controller
{

    /**
     * @Route("plan/downloadByName", name="api_get_plan_by_name")
     * @Method({"POST"})
     */
    public function downloadByName(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Plan');

        $results = null;

        if (empty($request->get('name'))) {
            $results = $repo->findBy([
                'sessionId' => null,
                'user' => $this->getUser()
            ]);
        } else {
            $results = $repo->createQueryBuilder('o')
                ->select('o')
                ->where('o.user = :user')
                ->andWhere('o.sessionId IS NULL')
                ->andWhere('o.name LIKE :name')
                ->setParameter('user', $this->getUser())
                //->setParameter('sessionId', null)
                ->setParameter('name', '%'.addcslashes($request->get('name'), '%_').'%')
                ->getQuery()
                ->getResult();
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($results, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("plan/downloadById", name="api_get_plan_by_id")
     * @Method({"POST"})
     */
    public function downloadById(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Plan');

        $results = $repo->findOneBy([
            'sessionId' => null,
            'user' => $this->getUser(),
            'planId' => $request->get('planId')
        ]);

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($results, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("plan/upload", name="api_post_plans")
     * @Method({"POST"})
     */
    public function upload(Request $request)
    {
        $counter = $this->get('app.plan.service')->saveData($request->request->all(), $this->getUser());

        return new JsonResponse(
            $this->get('jms_serializer')->serialize([ 'inserted' => $counter ], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("plan/edit", name="api_edit_plan")
     * @Method({"POST"})
     */
    public function edit(Request $request)
    {
        $plan = $this->get('app.plan.service')->editData($request->request->all(), $this->getUser());

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($plan, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("plan/delete", name="api_delete_plan")
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
                'sessionId' => null,
                'user' => $user,
                'planId' => $param
            ]);

            $dataLen = count($data);

            $this->get('app.plan.service')->removeBulk($data);
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
