<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller;

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
        return $this->render('GloryUserBundle:Security:login.html.twig', $data);
    }

}
