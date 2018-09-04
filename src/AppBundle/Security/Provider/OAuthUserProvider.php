<?php namespace AppBundle\Security\Provider;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Class OAuthUserProvider
 */
class OAuthUserProvider extends BaseClass
{

    protected $session;

    public function __construct(Session $session, UserManagerInterface $userManager, array $properties) {
        $this->session = $session;
        parent::__construct( $userManager, $properties );
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $socialID = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
        $email = $response->getEmail();
        //check if the user already has the corresponding social account

        if($user !== null){
            $checker = new UserChecker();
            $checker->checkPreAuth($user);
            return $user;
        }

        $user = $this->userManager->findUserByEmail($email);

        if($user !== null){
            $service = $response->getResourceOwner()->getName();
            switch ($service) {
                case 'google':
                    $user->setGoogleId($socialID);
                    break;
                case 'facebook':
                    $user->setFacebookId($socialID);
                    break;
            }
            $this->userManager->updateUser($user);
            return $user;
        }


        try {
            throw new AccountNotLinkedException(sprintf("User not found."));
        }
        catch ( AccountNotLinkedException $e ) {

//            dump($response->getResourceOwner()->getName());
//            dump($response->getResponse());die;
//            $this->session->set('type', $value);
            $this->session->set( 'oauth.resource', $response->getResourceOwner()->getName() );
            $this->session->set( 'oauth.id', $response->getResponse()['id'] );
            $this->session->set( 'oauth.response', $response->getResponse());
            throw $e;
        }
    }
}