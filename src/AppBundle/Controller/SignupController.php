<?php namespace AppBundle\Controller;

use AppBundle\Form\FacebookRegistrationType;
use AppBundle\Form\GoogleRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class SignupController extends Controller
{
    /**
     * @Route("/register/facebook", name="fb_register")
     */
    public function facebookAction(Request $request)
    {
        $session = $request->getSession();

        $resource = $session->get('oauth.resource');
        if ($resource !== 'facebook') {
            return $this->redirectToRoute('homepage');
        }

        $userManager = $this->get('fos_user.user_manager');
        $newUser = $userManager->createUser();

        $form = $this->createForm(FacebookRegistrationType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $oauthResp = $session->get('oauth.response');
            $newUser->setFacebookId($session->get('oauth.id'));
            $newUser->setEnabled(true);
            $newUser->setEmail($oauthResp['email']);
            $newUser->setFirstName($oauthResp['first_name']);
            $newUser->setLastName($oauthResp['last_name']);

            $userManager->updateUser($newUser);

            try {
                $this->get('hwi_oauth.user_checker')->checkPostAuth($newUser);
            } catch (AccountStatusException $e) {
                // Don't authenticate locked, disabled or expired users
                return;
            }

            $session->remove('oauth.resource');
            $session->remove('oauth.id');
            $session->getFlashBag()
                ->add('success', 'You\'re succesfully registered!');

            $token = new UsernamePasswordToken($newUser, null, 'main', $newUser->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signup/facebook_signup.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/register/google", name="google_register")
     */
    public function googleAction(Request $request)
    {
        $session = $request->getSession();

        $resource = $session->get('oauth.resource');
        if ($resource !== 'google') {
            return $this->redirectToRoute('homepage');
        }

        $userManager = $this->get('fos_user.user_manager');
        $newUser = $userManager->createUser();

        $form = $this->createForm(GoogleRegistrationType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $oauthResp = $session->get('oauth.response');
            $newUser->setFacebookId($session->get('oauth.id'));
            $newUser->setEnabled(true);
            $newUser->setEmail($oauthResp['email']);
            $newUser->setFirstName($oauthResp['family_name']);
            $newUser->setLastName($oauthResp['given_name']);

            $userManager->updateUser($newUser);

            try {
                $this->get('hwi_oauth.user_checker')->checkPostAuth($newUser);
            } catch (AccountStatusException $e) {
                // Don't authenticate locked, disabled or expired users
                return;
            }

            $session->remove('oauth.resource');
            $session->remove('oauth.id');
            $session->getFlashBag()
                ->add('success', 'You\'re succesfully registered!');

            $token = new UsernamePasswordToken($newUser, null, 'main', $newUser->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signup/google_signup.html.twig', array(
            'form' => $form->createView()
        ));
    }
//
//    /**
//     * @Route("/register", name="register")
//     */
    public function registerAction(Request $request)
    {
        $session = $request->getSession();

        $resource = $session->get('oauth.resource');
        if ($resource !== 'google') {
            return $this->redirectToRoute('homepage');
        }

        $userManager = $this->get('fos_user.user_manager');
        $newUser = $userManager->createUser();

        $form = $this->createForm(GoogleRegistrationType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $oauthResp = $session->get('oauth.response');
            $newUser->setFacebookId($session->get('oauth.id'));
            $newUser->setEnabled(true);
            $newUser->setEmail($oauthResp['email']);
            $newUser->setFirstName($oauthResp['family_name']);
            $newUser->setLastName($oauthResp['given_name']);

            $userManager->updateUser($newUser);

            try {
                $this->get('hwi_oauth.user_checker')->checkPostAuth($newUser);
            } catch (AccountStatusException $e) {
                // Don't authenticate locked, disabled or expired users
                return;
            }

            $session->remove('oauth.resource');
            $session->remove('oauth.id');
            $session->getFlashBag()
                ->add('success', 'You\'re succesfully registered!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('signup/google_signup.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
