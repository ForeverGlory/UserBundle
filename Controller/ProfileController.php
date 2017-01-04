<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Description of Password
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class ProfileController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->getUserOrThrowException();
        return $this->render('GloryUserBundle:Profile:index.html.twig', array(
                    'user' => $user
        ));
    }

    public function editAction(Request $request, $field = null)
    {
        $user = $this->getUserOrThrowException();
        //$form = $this->createForm('glory_user_profile_form', $user);
        $formBuilder = $this->createFormBuilder($user);
        if ($field) {
            switch ($field) {
                case 'username':
                    $formBuilder->add('username', 'text');
                    break;
                case 'profile':
                    break;
            }
        }
        $formBuilder->add('submit', 'submit');
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get('glory_user.user_manager');
            $userManager->updateUser($user);

            $this->addFlash('success', printf('Profile updated.'));
            return $this->redirectToRoute('glory_user_profile');
        }
        return $this->render('GloryUserBundle:Profile:edit.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
        ));
    }

    /**
     * 修改密码 
     * @see \FOS\UserBundle\Controller\ChangePasswordController::changePasswordAction()
     */
    public function passwordAction(Request $request)
    {
        $user = $this->getUserOrThrowException();

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);
            $this->addFlash('success', printf('Password changed.'));

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('glory_user_password');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('GloryUserBundle:Profile:password.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function avatarAction(Request $request)
    {
        $user = $this->getUserOrThrowException();
        $form = $this->createFormBuilder($user)
                ->add('avatar', FileType::class, array('label' => '上传头像', 'data_class' => null))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $user->getAvatar();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('avatar_directory'), $fileName
            );
            $user->setAvatar('/uploads/' . $fileName);

            $manager = $this->get('fos_user.user_manager');
            $manager->updateUser($user);

            return $this->redirectToRoute('glory_user_profile');
        }
        return $this->render('GloryUserBundle:Profile:avatar.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
