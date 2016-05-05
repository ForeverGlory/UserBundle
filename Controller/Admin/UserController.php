<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\Bundle\UserBundle\Model\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Description of UserController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserController extends Controller
{

    public function listAction(Request $request)
    {
        $userManager = $this->getUserManager();
        $users = $userManager->findUsers();
        return $this->render('GloryUserBundle:Admin/User:list.html.twig', array(
                    'users' => $users
        ));
    }

    public function showAction(Request $request, $id)
    {
        $user = $this->getUserManager()->findUserBy(['id' => $id]);
    }

    public function createAction(Request $request)
    {
        
    }

    public function editAction(Request $request, $id)
    {
        
    }

    public function deleteAction(Request $request, $id)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->findUserBy(['id' => $id]);
        $userManager->deleteUser($user);
    }

    /**
     * @return UserManager
     */
    protected function getUserManager()
    {
        return $this->get('glory_user.user_manager');
    }

}
