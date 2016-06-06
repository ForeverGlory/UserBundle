<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Glory\Bundle\UserBundle\Model\UserManager;
use Glory\Bundle\UserBundle\Model\GroupManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;

/**
 * Description of UserController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserController extends Controller
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sql = 'select user from ' . $this->getUserManager()->getClass() . ' user';
        $query = $em->createQuery($sql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->getInt('page', 1), 20
        );
        
        return $this->render('GloryUserBundle:Admin/User:list.html.twig', array(
                    'groups' => array(),
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
        $form = $this->createFormBuilder($user)
                ->add('username', 'text')
                ->add('plainPassword', 'password', [
                    'label' => 'Password'
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $form->getData();
            $this->getUserManager()->updateUser($user);
            return $this->redirectToRoute('glory_user_manage');
        }
        return $this->render('GloryUserBundle:Admin/User:create.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $user = $this->getUserManager()->findUserBy(['id' => $id]);

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            return $response;
        }
        return $this->render('GloryUserBundle:Admin/User:edit.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->findUserBy(['id' => $id]);
        if ($user) {
            $userManager->deleteUser($user);
        }
        return $this->redirectToRoute('glory_user_manage');
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
