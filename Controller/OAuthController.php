<?php

namespace Glory\Bundle\UserBundle\Controller;

use HWI\Bundle\OAuthBundle\Controller\ConnectController;
use Symfony\Component\HttpFoundation\Request;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @see HWI\Bundle\OAuthBundle\Controller\ConnectController
 */
class OAuthController extends ConnectController
{

    /**
     * oauth 关联
     * @see parent::connectAction()
     */
    public function connectAction(Request $request)
    {
        $hasUser = $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
        $error = $this->getErrorForRequest($request);
        if ($error && $error instanceof AccountNotLinkedException) {
            $userManager = $this->get('glory_user.user_manager');
            $oauth = $this->getOAuthFromError($error);
            if (!$oauth) {
                throw new \RuntimeException('oauth is not exist.');
            }
            if ($hasUser) {
                //已登录，进行自动绑定/取消绑定
                $userManager->bindOAuth($this->getUser(), $oauth);
                //todo: 进行登录、从哪来跳回哪去
            } else {
                //未登录，进入第三方注册绑定流程
                $key = time();
                $request->getSession()->set('_hwi_oauth.registration_error.' . $key, $error);

                return $this->redirectToRoute('glory_user_oauth_register', array('key' => $key));
            }
        } elseif ($error) {
            throw $error;
        }
        return $this->redirectToRoute('glory_user_login');
    }

    /**
     * 注册、关联 Oauth与User
     * @return Response
     * @throws \Exception
     */
    public function registerAction(Request $request, $key)
    {
        $hasUser = $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($hasUser) {
            throw $this->createAccessDeniedException(sprintf('You have logged in.'));
        }
        $userManager = $this->get('fos_user.user_manager');
        $session = $request->getSession();
        if (time() - $key > 300) {
            throw new \Exception('Timeout, please try again.');
        }
        $error = $session->get('_hwi_oauth.registration_error.' . $key);
        $oauth = $this->getOAuthFromError($error);

        $user = $userManager->createUser();
        $user->setUsername($oauth->getNickname());
        $form = $this->createFormBuilder($user)
                ->add('username', 'text', array(
                    'label' => '用户名',
                    'required' => true
                ))
                ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $user = $form->getData();
            $user->setEnabled(true);
            if ($form->isValid()) {
                $oldUser = $userManager->findUserByUsername($user->getUsername());
                if ($oldUser) {
                    $this->addFlash('warning', sprintf('Username %s is exist. Please use other name.', $user->getUsername()));
                } else {
                    $dispatcher = $this->get('event_dispatcher');
                    $event = new FormEvent($form, $request);
                    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                    $userManager->updateUser($user);
                    $this->get('glory_user.user_manager')->bindOAuth($user, $oauth);
                    $session->remove('_hwi_oauth.registration_error.' . $key);
                    return $this->authenticateUser($request, $user, $error->getResourceOwnerName(), $error->getRawToken());
                }
            }
        }
        return $this->render('GloryUserBundle:OAuth:register.html.twig', array(
                    'key' => $key,
                    'form' => $form->createView(),
                    'oauth' => $oauth,
        ));
    }

    public function loginAction(Request $request, $key)
    {
        $hasUser = $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($hasUser) {
            throw $this->createAccessDeniedException(sprintf('You have logged in.'));
        }
        $userManager = $this->get('fos_user.user_manager');
        $session = $request->getSession();
        if (time() - $key > 300) {
            throw new \Exception('Timeout, please try again.');
        }
        $error = $session->get('_hwi_oauth.registration_error.' . $key);
        $oauth = $this->getOAuthFromError($error);
        $username = $oauth->getNickname();
        if ($request->isMethod('post')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            if (!$password) {
                $this->addFlash('error', sprintf('Please input password'));
            } else {
                $user = $userManager->findUserByUsername($username);
                if (!$user) {
                    $this->addFlash('error', sprintf('User is not exist.'));
                } elseif (!$this->get('security.encoder_factory')->getEncoder($user)->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
                    $this->addFlash('error', sprintf('Invalid credentials.'));
                } else {
                    $this->get('glory_user.user_manager')->bindOAuth($user, $oauth);
                    $session->remove('_hwi_oauth.registration_error.' . $key);
                    return $this->authenticateUser($request, $user, $error->getResourceOwnerName(), $error->getRawToken());
                }
            }
        }
        return $this->render('GloryUserBundle:OAuth:login.html.twig', array(
                    'key' => $key,
                    'username' => $username,
                    'oauth' => $oauth,
        ));
    }

    public function redirectToServiceAction(Request $request, $service)
    {
        return parent::redirectToServiceAction($request, $service);
    }

    protected function getOAuthFromError(AccountNotLinkedException $error = null)
    {
        if (!$error) {
            throw new \Exception('Timeout.');
        }
        $userManager = $this->get('glory_user.user_manager');
        $oauth = $userManager->findOAuth(array('owner' => $error->getResourceOwnerName(), 'username' => $error->getUsername()));
        return $oauth;
    }

    /**
     * //todo: 应该写在防火墙来处理 ~_~
     * @see parent::authenticateUser
     */
    protected function authenticateUser(Request $request, UserInterface $user, $resourceOwnerName, $accessToken, $fakeLogin = true)
    {
        try {
            $this->container->get('hwi_oauth.user_checker')->checkPostAuth($user);
        } catch (AccountStatusException $e) {
            return;
        }

        $token = new OAuthToken($accessToken, $user->getRoles());
        $token->setResourceOwnerName($resourceOwnerName);
        $token->setUser($user);
        $token->setAuthenticated(true);

        $this->setToken($token);

        if ($fakeLogin) {
            // Since we're "faking" normal login, we need to throw our INTERACTIVE_LOGIN event manually
            $this->container->get('event_dispatcher')->dispatch(
                    SecurityEvents::INTERACTIVE_LOGIN, new InteractiveLoginEvent($request, $token)
            );
        }
        //@see service security.authentication.success_handler
        //Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler
        //$response = $this->successHandler->onAuthenticationSuccess($request, $token);
        foreach ($this->container->getParameter('hwi_oauth.firewall_names') as $providerKey) {
            if ($targetUrl = $request->getSession()->get('_security.' . $providerKey . '.target_path')) {
                $request->getSession()->remove('_security.' . $providerKey . '.target_path');
                return $this->redirect($targetUrl);
            }
        }
    }

}
