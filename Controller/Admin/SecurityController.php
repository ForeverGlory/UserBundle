<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller\Admin;

use FOS\UserBundle\Controller\SecurityController as Controller;

/**
 * Description of SecurityController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class SecurityController extends Controller
{

    protected function renderLogin(array $data)
    {
        return $this->render('GloryUserBundle:Admin:login.html.twig', $data);
    }

}
