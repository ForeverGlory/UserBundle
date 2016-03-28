<?php

namespace Glory\Bundle\UserBundle\Security\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;

class LoginSuccessHandler extends DefaultAuthenticationSuccessHandler
{

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()) {
            //todo: 
        }

        return parent::onAuthenticationSuccess($request, $token);
    }

}
