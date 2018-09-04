<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{

    /**
     * @Route("event/days", name="api_get_event_days")
     * @Method({"GET"})
     */
    public function getDays(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        $rows = $repo->findBy([
            'user' => $this->getUser()
        ]);

        $results = [];

        foreach ($rows as $row) {
            $timestamp = $row->getTimestamp();
            if (isset($timestamp)) {
                $results[] = $timestamp;
            }
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($results, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("event/downloadByTimestamp", name="api_get_events_by_timestamp")
     * @Method({"POST"})
     */
    public function downloadByTimestamp(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

        $results = $repo->findByTimestampRange(
            $this->getUser(),
            $request->get('timestampFrom'),
            $request->get('timestampTo')
        );

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($results, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("event/upload", name="api_post_events")
     * @Method({"POST"})
     */
    public function upload(Request $request)
    {
        $counter = $this->get('app.event.service')->saveData($request->request->all(), $this->getUser());

        return new JsonResponse(
            $this->get('jms_serializer')->serialize([ 'inserted' => $counter ], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("event/edit", name="api_edit_event")
     * @Method({"POST"})
     */
    public function edit(Request $request)
    {
        $obj = $this->get('app.event.service')->editData($request->request->all(), $this->getUser());

        return new JsonResponse(
            $this->get('jms_serializer')->serialize($obj, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("event/delete", name="api_delete_event")
     * @Method({"POST"})
     */
    public function delete(Request $request)
    {
        $param = $request->request->all();

        $dataLen = 0;

        if (isset($param)) {
            $user = $this->getUser();

            $repo = $this->getDoctrine()->getRepository('AppBundle:Event');

            $data = $repo->findBy([
                'user' => $user,
                'eventId' => $param
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
