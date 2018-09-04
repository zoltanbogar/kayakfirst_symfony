<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 06. 15.
 * Time: 13:13
 */

namespace AppBundle\Controller\Firebase;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @Route("/firebase/login")
     * @Method("POST")
     */
    public function newAction(Request $request){
        $params = $request->request->all();
        $serializer = $this->get('jms_serializer');

        $response = [];

        //$userRepo = $this->getDoctrine()->getRepository('AppBundle:User');

        $factory = $this->get('security.encoder_factory');
        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($params['username']);
        $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
            ->findOneBy(array('username' => $params['username']));

        if(!$user){
            return new JsonResponse(
                $serializer->serialize(
                    $response,
                    'json'
                ),
                Response::HTTP_OK,
                [],
                true
            );
        }

        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $params['password'], $salt)) {
            return new JsonResponse(
                $serializer->serialize(
                    $response,
                    'json'
                ),
                Response::HTTP_OK,
                [],
                true
            );
        }

        $response["id"] = $user->getId();
        $response["email"] = $user->getEmail();
        $response["first_name"] = $user->getFirstName();
        $response["last_name"] = $user->getLastName();
        $response["username"] = $user->getUsername();

        return new JsonResponse(
            $serializer->serialize(
                $response,
                'json'
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}