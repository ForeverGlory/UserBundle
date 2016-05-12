<?php

/**
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of GroupController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupController extends Controller
{

    public function listAction(Request $request)
    {
        $groups = $this->get('fos_user.group_manager')->findGroups();
        return $this->render('GloryUserBundle:Admin/Group:list.html.twig', array(
                    'groups' => $groups
        ));
    }

    public function createAction(Request $request)
    {
        /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
        $groupManager = $this->get('fos_user.group_manager');
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.group.form.factory');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $group = $groupManager->createGroup('');
        $roles = array();

        $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_INITIALIZE, new GroupEvent($group, $request));

        $form = $formFactory->createForm();
        $form->setData($group);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_SUCCESS, $event);

            $groupManager->updateGroup($group);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_group_show', array('groupName' => $group->getName()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

            return $response;
        }
        return $this->render('GloryUserBundle:Admin/Group:create.html.twig', array(
                    'group' => $group,
                    'roles' => $roles,
                    'form' => $form->createview(),
        ));
    }

    public function showAction(Request $request, $id)
    {
        $group = $this->getGroup($id);

        return $this->render('GloryUserBundle:Admin/Group:show.html.twig', array(
                    'group' => $group
        ));
    }

    public function editAction(Request $request, $id)
    {
        $group = $this->getGroup($id);

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseGroupEvent($group, $request);
        $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.group.form.factory');

        $form = $formFactory->createForm();
        $form->setData($group);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
            $groupManager = $this->get('fos_user.group_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_SUCCESS, $event);

            $groupManager->updateGroup($group);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_group_show', array('groupName' => $group->getName()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

            return $response;
        }

        return $this->render('GloryUserBundle:Admin/Group:edit.html.twig', array(
                    'form' => $form->createview(),
                    'group' => $group,
                    'group_name' => $group->getName(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $group = $this->getGroup($id);
        $this->get('fos_user.group_manager')->deleteGroup($group);

        $response = new RedirectResponse($this->generateUrl('fos_user_group_list'));

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(FOSUserEvents::GROUP_DELETE_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

        return $response;
    }

    protected function getGroup($id)
    {
        $groupManager = $this->get('fos_user.group_manager');
        $group = $groupManager->findGroupBy(['id' => $id]);

        if (empty($group)) {
            throw new NotFoundHttpException(sprintf('The group  does not exist for id "%s"', $id));
        }

        return $group;
    }

}
