<?php namespace AppBundle\Controller;

use AppBundle\Form\FacebookRegistrationType;
use AppBundle\Form\GoogleRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{

    /**
     * @Route("/profile/edit", name="profile_edit")
     * @Method({"POST"})
     */
    public function postSaveProfile(Request $request){
    	$userManager = $this->get('fos_user.user_manager');
    	$serializer = $this->get('jms_serializer');
        $userService = $this->get('app.user.service');

    	$rowEditedData = $request->request->get('fos_user_profile_form');
    	$pwencoder = $this->get('security.password_encoder');
    	$objUser =  $this->get('security.token_storage')->getToken()->getUser();

    	if(!$pwencoder->isPasswordValid($objUser, $rowEditedData["password"])){
    		return $this->redirectToRoute('fos_user_profile_edit', array('update_error' => "INVALID_PASSWORD"), 301);
    	}

        $objUser->setEmail($rowEditedData["email"]);
        $objUser->setFirstName($rowEditedData["first_name"]);
        $objUser->setLastName($rowEditedData["last_name"]);
        $objUser->setBodyWeight($rowEditedData["bodyWeight"]);
        $objUser->setClub($rowEditedData["club"]);
        $objUser->setArtOfPaddling($rowEditedData["artOfPaddling"]);

        $userManager->updateUser($objUser);

		return $this->redirectToRoute('fos_user_profile_show', array(), 301);
    }

    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
