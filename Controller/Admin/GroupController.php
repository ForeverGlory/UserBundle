<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller\Admin;

use FOS\UserBundle\Controller\GroupController as BaseGroupController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of GroupController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupController extends BaseGroupController
{

    public function listAction()
    {
        return parent::listAction();
    }

    public function createAction(Request $request)
    {
        return parent::newAction($request);
    }

    public function editAction(Request $request, $groupName)
    {
        return parent::editAction($request, $groupName);
    }

    public function deleteAction(Request $request, $groupName)
    {
        return parent::deleteAction($request, $groupName);
    }

    public function showAction($groupName)
    {
        return parent::showAction($groupName);
    }

}
