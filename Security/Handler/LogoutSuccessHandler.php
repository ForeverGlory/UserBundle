<?php

namespace Glory\Bundle\UserBundle\Security\Handler;

use Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;
use Symfony\Component\HttpFoundation\Request;

class LogoutSuccessHandler extends DefaultLogoutSuccessHandler
{

    public function onLogoutSuccess(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            //todo: 
        }

        return parent::onLogoutSuccess($request);
    }

}
