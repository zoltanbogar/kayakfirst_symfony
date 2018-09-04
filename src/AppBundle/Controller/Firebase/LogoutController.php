<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 06. 18.
 * Time: 17:02
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
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class LogoutController extends Controller
{
    /**
     * @Route("/logout_user")
     */
    public function logoutAction(Request $request){
        $user = $this->getUser();

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../../../AppBundle/firebase_service_account.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $database = $firebase->getDatabase();

        $webOnlineUsers = $database->getReference('js_web_online_users/');
        $userNode = $webOnlineUsers->getChild($user->getId())->remove();

        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        return $this->redirectToRoute('homepage', array(), 301);
    }
}