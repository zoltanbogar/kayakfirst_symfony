<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\PushToken;
use AppBundle\Entity\AppMessage;
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
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;

class UserController extends Controller
{
    /**
     * @Route("/users/current", name="api_get_current_user")
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
     * @Route("/users/update", name="api_post_update_current_user")
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
            $date = new \DateTime(date('Y-m-d',$request->get('birthDate') / 1000));
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

        if($request->get('unitWeight')){
            $user->setUnitWeight($request->get('unitWeight'));
        }

        if($request->get('unitDistance')){
            $user->setUnitDistance($request->get('unitDistance'));
        }

        if($request->get('unitPace')){
            $user->setUnitPace($request->get('unitPace'));
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
     * @Route("/users/password/update", name="api_post_update_current_user_password")
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
     * @Route("/users/pwreset", name="api_post_pw_reset_request")
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

        $ttl = $this->container->getParameter('fos_user.resetting.retry_ttl');

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

    /**
     * @Route("/users/uploadPushId", name="api_post_push_id")
     * @Method({"POST"})
     */
    public function uploadPushId(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository('AppBundle:PushToken');

        $shouldFlush = false;

        if ($request->get('android_token')) {
            $token = $repo->findOneBy([
                'user' => $user,
                'tokenType' => 'android'
            ], [ 'id' => 'DESC' ]);

            if ($token == null) {
                $token = new PushToken();
            }

            $token->setUser($user);

            $token->setTokenType('android');

            $token->setToken($request->get('android_token'));

            $token->setVersionCode($request->get('version_code'));

            $em->persist($token);

            $shouldFlush = true;
        }

        if ($request->get('ios_token')) {
            $token = $repo->findOneBy([
                'user' => $user,
                'tokenType' => 'ios'
            ], [ 'id' => 'DESC' ]);

            if ($token == null) {
                $token = new PushToken();
            }

            $token->setUser($user);

            $token->setTokenType('ios');

            $token->setToken($request->get('ios_token'));

            $token->setVersionCode($request->get('version_code'));

            $em->persist($token);

            $shouldFlush = true;
        }

        if ($shouldFlush) {
            $em->flush();
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize('ok', 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/testPushNotification", name="api_post_push_notification_self")
     * @Method({"POST"})
     */
    public function testPushNotification(Request $request)
    {
        $user = $this->getUser();

        $repo = $this->getDoctrine()->getRepository('AppBundle:PushToken');

        $tokens = $repo->findBy([
            'user' => $user
        ]);

        $messageToPush = $request->get('message');

        if ($messageToPush === null) {
            $messageToPush = 'Test message';
        }

        foreach ($tokens as $k => $token) {
            $message = null;

            if ($token->getTokenType() == 'ios') {
                $message = new iOSMessage();
            } elseif ($token->getTokenType() == 'android') {
                $message = new AndroidMessage();
                $message->setGCM(true);
            }

            $message->setMessage($messageToPush);

            $message->setDeviceIdentifier($token->getToken());

            $this->container->get('rms_push_notifications')->send($message);
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize('ok', 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/broadcastPush", name="api_post_broadcast_push")
     * @Method({"POST"})
     */
    public function broadcastPush(Request $request)
    {
        $messageToPush = $request->get('message');

        if ($messageToPush === null) {
            return new JsonResponse(
                $this->get('jms_serializer')->serialize([
                    'error' => 'Missing "message" field!'
                ], 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $repo = $this->getDoctrine()->getRepository('AppBundle:PushToken');

        $tokens = $repo->createQueryBuilder('t')
            ->select('t')
            ->where('t.user IS NOT NULL')
            ->getQuery()
            ->getResult();

        foreach ($tokens as $k => $token) {
            $message = null;

            if ($token->getTokenType() == 'ios') {
                $message = new iOSMessage();
            } elseif ($token->getTokenType() == 'android') {
                $message = new AndroidMessage();
                $message->setGCM(true);
            }

            $message->setMessage($messageToPush);

            $message->setDeviceIdentifier($token->getToken());

            $this->container->get('rms_push_notifications')->send($message);
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize('ok', 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/users/getMessage", name="api_get_message")
     * @Method({"POST"})
     */
    public function getMessage(Request $request)
    {
        $message = '';

        $repo = $this->getDoctrine()->getRepository('AppBundle:AppMessage');

        /*$result = $repo->findOneBy([
            'languageCode' => $request->get('languageCode'),
            'messageId' => $request->get('messageId')
        ]);*/

        if ($request->get('languageCode') != null && strlen($request->get('languageCode')) >= 2) {
            $result = $repo->createQueryBuilder('t')
               ->Where('t.languageCode LIKE :languageCode')
               ->setParameter('languageCode', addcslashes(substr($request->get('languageCode'), 0, 2), '%_').'%')
               ->setMaxResults(1)
               ->getQuery()
               ->getOneOrNullResult();

            if (isset($result) && $result->getMessageLocalized() !== null ) {
                $message = $result->getMessageLocalized();
            }
        }

        return new JsonResponse(
            $this->get('jms_serializer')->serialize(array(
                'message' => $message
            ), 'json'),
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
