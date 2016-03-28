<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SecurityController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        return parent::loginAction($request);
    }

    protected function renderLogin(array $data)
    {
        return $this->render('GloryUserBundle::login.html.twig', $data);
    }

}
