<?php namespace AppBundle\Controller\Web;

use AppBundle\Form\PasswordResetRequestForm;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * @Route("/users/current", name="webapi_get_current_user")
     * @Method({"GET"})
     */
    public function getCurrentUserAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $userService = $this->get('app.user.service');

        $user =  $this->get('security.token_storage')->getToken()->getUser();

        return new JsonResponse(
            $serializer->serialize($userService->userObjectReducer($user),'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/update", name="webapi_post_update_current_user")
     * @Method({"POST"})
     */
    public function postUpdateCurrentUserAction(Request $request)
    {
        $user = $this->getUser();
        $serializer = $this->get('jms_serializer');
        $userService = $this->get('app.user.service');

        if($request->get('lastName')){
            $user->setLastName($request->get('lastName'));
        }

        if($request->get('firstName')){
            $user->setFirstName($request->get('firstName'));
        }

        if($request->get('email')){
            $user->setEmail($request->get('email'));
        }

        if($request->get('bodyWeight')){
            $user->setBodyWeight($request->get('bodyWeight'));
        }

        if($request->get('gender')){
            $user->setGender($request->get('gender'));
        }

        if($request->get('birthDate')){
            //date_default_timezone_set('UTC');
            $date = new \DateTime(date('Y-m-d',$request->get('birthDate')));
            $user->setBirthDate($date);
        }

        if($request->get('country')){
            $user->setCountry($request->get('country'));
        }

        if($request->get('username')){
            $user->setUsername($request->get('username'));
        }

        if($request->get('club')){
            $user->setClub($request->get('club'));
        }

        if($request->get('artOfPaddling')){
            $user->setArtOfPaddling($request->get('artOfPaddling'));
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new JsonResponse(
                $serializer->serialize($this->errorConverter($errors), 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();

        return new JsonResponse(
            $serializer->serialize($userService->userObjectReducer($user), 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/password/update", name="webapi_post_update_current_user_password")
     * @Method({"POST"})
     */
    public function postPasswordUpdate(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $currentPassword = $request->get('currentPassword');
        $newPassword = $request->get('newPassword');

        if(!$currentPassword || !$newPassword){
            return new JsonResponse(
                $serializer->serialize('INVALID_CREDENTIALS', 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $userService = $this->get('app.user.service');

        $user = $this->getUser();

        $pwencoder = $this->get('security.password_encoder');

        if(!$pwencoder->isPasswordValid($user,$currentPassword)){
            return new JsonResponse(
                $serializer->serialize('INVALID_CREDENTIALS', 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $encodedNePassword = $pwencoder->encodePassword($user,$newPassword);

        $user->setPassword($encodedNePassword);

        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();

        return new JsonResponse(
            $serializer->serialize($userService->userObjectReducer($user), 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/pwreset", name="webapi_post_pw_reset_request")
     * @Method({"POST"})
     */
    public function postPwResetRequestCurrentUserAction(Request $request)
    {
        $email = $request->request->get('email');
        $serializer = $this->get('jms_serializer');

        if(!$email){
            return new JsonResponse(
                $serializer->serialize('MISSING_EMAIL', 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($email);

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /* Dispatch init event */
        $event = new GetResponseNullableUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $ttl = $this->container->getParameter('fos_user.resetting.token_ttl');

        if (null !== $user && !$user->isPasswordRequestNonExpired($ttl)) {
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            if (null === $user->getConfirmationToken()) {
                /** @var $tokenGenerator TokenGeneratorInterface */
                $tokenGenerator = $this->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }

            /* Dispatch confirm event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->get('fos_user.user_manager')->updateUser($user);

            /* Dispatch completed event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
        }
        $serializer = $this->get('jms_serializer');

        return new JsonResponse(
            $serializer->serialize('ok', 'json'),
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
