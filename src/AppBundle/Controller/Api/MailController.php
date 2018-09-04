<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 08. 19.
 * Time: 0:13
 */

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    /**
     * @Route("api_contact_us", name="api_contact_us")
     * @Method("POST")
     */
    public function contactEmailAction(Request $request){
        $params = $request->request->all();
        $serializer = $this->get('jms_serializer');

        $message = \Swift_Message::newInstance()
            ->setSubject('New message from website')
            ->setFrom($params["email"])
            //->setTo('web@kayakfirst.com')
            ->setTo(['web@kayakfirst.com', 'info@kayakfirst.com'])
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/contactus.html.twig',
                    array('name' => $params["name"]
                    , 'message' => $params["message"]
                    , 'email' => $params["email"])
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        if($this->get('mailer')->send($message)){
            return new JsonResponse(
                $serializer->serialize(
                    ['message' => 'Thanks for contacting us! We will be in touch with you shortly.'],
                    'json'
                ),
                Response::HTTP_OK,
                [],
                true
            );
        }

        return new JsonResponse(
            $serializer->serialize(
                ['message' => 'Unexpected error.'],
                'json'
            ),
            Response::HTTP_SERVICE_UNAVAILABLE,
            [],
            true
        );
    }
}