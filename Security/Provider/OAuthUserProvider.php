<?php

namespace Glory\Bundle\UserBundle\Security\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class OAuthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * Constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository('GloryUserBundle:User')->findUser(array('username' => $username));
        if (!$user) {
            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user_manager = $this->container->get('glory_user.user_manager');
        $resourceOwnerName = $response->getResourceOwner()->getName();
        $oauth = $user_manager->findOAuth(array('owner' => $resourceOwnerName, 'username' => $response->getUsername()));
        if (!$oauth) {
            $oauth = $user_manager->createOAuthFromResponse($response);
        } else {
            $user_manager->updateOAuthFromResponse($oauth, $response, true);
        }

        if (!$oauth || null == $user = $oauth->getUser()) {
            //throw new AccountNotLinkedException(sprintf("User '%s' not found.", $response->getUsername()));
            $exception = new AccountNotLinkedException(sprintf("User '%s' not found.", $response->getUsername()));
            $exception->setUsername($response->getUsername());
            throw $exception;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->em->getRepository('GloryUserBundle:User')->findOneByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->class || is_subclass_of($class, $this->class);
    }

}
