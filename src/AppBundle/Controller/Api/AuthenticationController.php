<?php namespace AppBundle\Controller\Api;

use HWI\Bundle\OAuthBundle\Controller\ConnectController;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends ConnectController
{


    /**
     * @Route("/login/google", name="api_login_google")
     * @Method({"POST"})
     */
    public function googleLoginAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $email = $request->get('email');
        $id = $request->get('id');

        if($email == null || $id == null){
            return new JsonResponse(
                $serializer->serialize("INVALID_GOOGLE_RESPONSE", 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $userRepo = $this->getDoctrine()->getRepository('AppBundle:User');

        $user = $userRepo->findOneBy([
            'googleId'    =>  $id
        ]);


        if(!$user){
            $user = $userRepo->findOneBy([
                'email'    =>  $email
            ]);

            if($user){
                $user->setGoogleId($id);
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
            }
        }

        if (!$user){
            return new JsonResponse(
                $serializer->serialize("Registration required", 'json'),
                Response::HTTP_UNAUTHORIZED,
                [],
                true
            );
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        $userService = $this->get('app.user.service');

        $JWTResponse = $this->get('app.security.authentication.handler.authentication_success')->handleAuthenticationSuccess($user, $token);

        return $JWTResponse;

//        return new JsonResponse($serializer->serialize([
//            'user'          =>  $userService->userObjectReducer($user),
//            'user_token'    =>  $token
//        ],'json'),
//            Response::HTTP_OK,
//            [],
//            true
//        );
    }

    /**
     * @Route("/login/facebook", name="api_login_facebook")
     * @Method({"POST"})
     */
    public function facebookLoginAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $userInformation = $this
            ->getResourceOwnerByName('facebook')
            ->getUserInformation(['access_token' => $request->get('code')]);

        if(!isset($userInformation->getResponse()['id'])){
            return new JsonResponse(
                $serializer->serialize("INVALIDE_FACEBOOK_RESPONSE", 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $userRepo = $this->getDoctrine()->getRepository('AppBundle:User');

        $user = $userRepo->findOneBy([
            'facebookId'    =>  $userInformation->getResponse()['id']
        ]);


        if(!$user){
            $user = $userRepo->findOneBy([
                'email'    =>  $userInformation->getResponse()['email']
            ]);

            if($user){
                $user->setFacebookId($userInformation->getResponse()['id']);
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
            }
        }

        if (!$user){
            return new JsonResponse(
                $serializer->serialize("Registration required", 'json'),
                Response::HTTP_UNAUTHORIZED,
                [],
                true
            );
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        $userService = $this->get('app.user.service');

        $JWTResponse = $this->get('app.security.authentication.handler.authentication_success')->handleAuthenticationSuccess($user, $token);

        return $JWTResponse;

//        return new JsonResponse($serializer->serialize([
//            'user'          =>  $userService->userObjectReducer($user),
//            'user_token'    =>  $token
//        ],'json'),
//            Response::HTTP_OK,
//            [],
//            true
//        );
    }

    /**
     * @Route("/login", name="api_login")
     * @Method({"POST"})
     */
    public function loginAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        if (!$request->request->get('username') || !$request->request->get('password')){
            return new JsonResponse(
                $serializer->serialize(['error' => 'MISSING_CREDENTIALS'], 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->findOneBy(['username' => $username]);

        if(!$user) {
            return new JsonResponse(
                $serializer->serialize(['error' => 'INVALID_CREDENTIALS'], 'json'),
                Response::HTTP_FORBIDDEN,
                [],
                true
            );
        }

        if(!$this->get('security.password_encoder')->isPasswordValid($user, $password)) {
            return new JsonResponse(
                $serializer->serialize(['error' => 'INVALID_CREDENTIALS'], 'json'),
                Response::HTTP_FORBIDDEN,
                [],
                true
            );
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        $userService = $this->get('app.user.service');

        $JWTResponse = $this->get('app.security.authentication.handler.authentication_success')->handleAuthenticationSuccess($user, $token);

        return $JWTResponse;

//        return new JsonResponse($serializer->serialize([
//                'user'          =>  $userService->userObjectReducer($user),
//                'user_token'    =>  $token
//            ],'json'),
//            Response::HTTP_OK,
//            [],
//            true
//        );
    }

    /**
     * @Route("/logout", name="api_logout")
     * @Method({"GET"})
     */
    public function logoutAction()
    {
        $serializer = $this->get('jms_serializer');

        return new JsonResponse($serializer->serialize("Ha ezt látod akkor vmi hiba van!",'json'),
            Response::HTTP_INTERNAL_SERVER_ERROR,
            [],
            true
        );
    }

    /**
     * @Route("/rest", name="api_logout_rest")
     * @Method({"GET"})
     */
    public function restAction()
    {
        $serializer = $this->get('jms_serializer');

        return new JsonResponse($serializer->serialize(['success'],'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/api_ecwid_login", name="api_ecwid_login")
     */
    public function api_ecwid_login(Request $request){
        $params = $request->request->all();
        $serializer = $this->get('jms_serializer');

        $strFullName = $params["firstName"] . " " . $params["lastName"];
        $response["ecwid_sso_profile"] = $this->checkEcwidSignOnSession($params["email"], $strFullName);

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

    protected function checkEcwidSignOnSession($strUserEmail, $strFullName){
        $numUserID = $this->checkIfEmailRegisteredInEcwid($strUserEmail, "secret_SPuzPcYRFffBh41AyVJ4Hf1Uv2gy5F5j", '14262098', $strFullName);
        $this->setEcwidSignOnSession($numUserID, $strUserEmail, $strFullName);

        $ecwid_sso_profile = $this->get('session')->get("ecwid_sso_profile");

        return $ecwid_sso_profile;
    }

    protected function setEcwidSignOnSession($numUserID, $strUserEmail, $strFullName){
        $user_data = array(
            'userId' => $numUserID,
            'profile' => array(
                'email' => $strUserEmail,
                'billingPerson' => array(
                    'name' => $strFullName
                )
            )
        );

        $key = "X37DpDfXQFYmvhJHjG74HXPfWBBTTZzM";
        $user_data['appClientId'] = "bmWzQL83eEQBrPkd";

        $user_data_encoded = base64_encode(json_encode($user_data));

        $time = time();
        $hmac = hash_hmac('sha1', "$user_data_encoded $time", $key);

        $sso_profile = "$user_data_encoded $hmac $time";

        $this->get('session')->set("ecwid_sso_profile", $sso_profile);
    }

    protected function checkIfEmailRegisteredInEcwid($strEmail, $strSecret, $numAppID, $strFullName){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.ecwid.com/api/v3/" . $numAppID . "/customers?email=" . $strEmail . "&token=" . $strSecret);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $content = trim(curl_exec($ch));
        curl_close($ch);
        $decodedContent = json_decode($content);

        if($decodedContent->total < 1){
            return $this->registerEcwidAccount($strEmail, $strSecret, $numAppID, $strFullName);
        } else {
            return $decodedContent->items[0]->id;
        }
    }

    protected function registerEcwidAccount($strEmail, $strSecret, $numAppID, $strFullName){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.ecwid.com/api/v3/" . $numAppID . "/customers?token=" . $strSecret,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "
                                        {
                                            \"email\": \"" . $strEmail . "\",
                                            \"billingPerson\": {
                                                \"name\": \"" . $strFullName . "\"
                                            }
                                        }",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $decodedResponse = json_decode($response);

            return $decodedResponse->id;
        }
    }
}