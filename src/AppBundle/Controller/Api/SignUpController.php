<?php namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpController extends Controller
{

    /**
     * @Route("/register", name="api_signup")
     * @Method({"POST"})
     */
    public function signupAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $user = new User();

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

        if($request->get('club')){
            $user->setClub($request->get('club'));
        }

        if($request->get('artOfPaddling')){
            $user->setArtOfPaddling($request->get('artOfPaddling'));
        }

        if($request->get('birthDate')){
            //date_default_timezone_set('UTC');
            $date = new \DateTime(date('Y-m-d',$request->get('birthDate') / 1000));
            $user->setBirthDate($date);
        }

        if($request->get('country')){
            $user->setCountry($request->get('country'));
        }

        if($request->get('password')){
            $user->setPlainPassword($request->get('password'));
        }

        if($request->get('username')){
            $user->setUsername($request->get('username'));
        }

        if($request->get('facebookId')){
            $user->setFacebookId($request->get('facebookId'));
        }

        if($request->get('googleId')){
            $user->setGoogleId($request->get('googleId'));
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

        $user->setEnabled(true);

        $validator = $this->get('validator');
        $errors = $validator->validate($user, null, ['Registration']);

        if (count($errors) > 0) {
            return new JsonResponse(
                $serializer->serialize($this->errorConverter($errors), 'json'),
                Response::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $userService = $this->get('app.user.service');

        return new JsonResponse(
            $serializer->serialize($userService->userObjectReducer($user), 'json'),
            Response::HTTP_OK,
            [],
            true);
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
