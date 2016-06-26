<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MyController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class MyController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->getUserOrThrowException();
        return $this->render('GloryUserBundle:My:index.html.twig', array(
                    'user' => $user
        ));
    }

}
