<?php namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            // redirect authenticated users to homepage
            return $this->redirect($this->generateUrl('homepage'));
        }
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':signin:form_login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
