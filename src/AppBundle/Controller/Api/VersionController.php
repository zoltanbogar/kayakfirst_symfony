<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\Version;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VersionController extends Controller
{

    /**
     * @Route("/version", name="api_get_version")
     * @Method({"GET"})
     */
    public function getVersion(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $repo = $this->getDoctrine()->getRepository('AppBundle:Version');

        $results = null;
        $results = $repo->findBy([ ]);

        /* $userService = $this->get('app.user.service');

        $user = $this->get('security.token_storage')->getToken()->getUser(); */

        return new JsonResponse(
            $serializer->serialize($results[0], 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

}
