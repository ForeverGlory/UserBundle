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

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of Controller
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Controller extends BaseController
{

    protected function getUserOrThrowException()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('This user does not have access to this section.');
        }
        return $user;
    }

}
