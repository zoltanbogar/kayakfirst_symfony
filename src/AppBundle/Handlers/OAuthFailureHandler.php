<?php namespace AppBundle\Handlers;

use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class OAuthFailureHandler implements AuthenticationFailureHandlerInterface
{

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception)
    {
        if ( !$exception instanceof AccountNotLinkedException ) {
            throw $exception;
        }

        if($request->getSession()->get('oauth.resource') == 'facebook'){
            return new RedirectResponse( $this->router->generate('fb_register') );
        } elseif ($request->getSession()->get('oauth.resource') == 'google'){
            return new RedirectResponse( $this->router->generate('google_register') );
        }
    }
}