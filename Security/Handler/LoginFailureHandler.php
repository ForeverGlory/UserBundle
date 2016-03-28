<?php

namespace Glory\Bundle\UserBundle\Security\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;

class LoginFailureHandler extends DefaultAuthenticationFailureHandler
{

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            //todo: 
        }
        
        return parent::onAuthenticationFailure($request, $exception);
    }

}
