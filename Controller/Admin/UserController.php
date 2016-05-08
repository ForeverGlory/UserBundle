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
use Glory\Bundle\UserBundle\Model\GroupManager;

/**
 * Description of UserController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserController extends Controller
{

    public function listAction(Request $request)
    {
        $query = $request->query;
        $criteria = $query->all();
        $orderBy = $query->get('order', 'created');
        $page = $query->get('page', 1);
        $limit = $query->get('limit', 20);
        $users = $this->getUserManager()->findUsers($criteria, $orderBy, $limit, ($page - 1) * $limit);
        $groups = $this->getGroupManager()->findGroups();
        $pagination = '';
        return $this->render('GloryUserBundle:Admin/User:list.html.twig', array(
                    'groups' => $groups,
                    'users' => $users,
                    'pagination' => $pagination
        ));
    }

    public function showAction(Request $request, $id)
    {
        $user = $this->getUserManager()->findUserBy(['id' => $id]);
        return $this->render('GloryUserBundle:Admin/User:show.html.twig', [
                    'user' => $user
        ]);
    }

    public function createAction(Request $request)
    {
        $user = $this->getUserManager()->createUser();
        return $this->render('GloryUserBundle:Admin/User:edit.html.twig', [
                    'user' => $user
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $user = $this->getUserManager()->findUser();
        return $this->render('GloryUserBundle:Admin/User:edit.html.twig', array(
                    'user' => $user
        ));
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

    /**
     * @return GroupManager
     */
    protected function getGroupManager()
    {
        return $this->get('glory_user.group_manager');
    }

}
