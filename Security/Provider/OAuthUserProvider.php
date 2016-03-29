<?php

namespace Glory\Bundle\UserBundle\Security\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Glory\Bundle\UserBundle\Entity\OAuth;

class OAuthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry    Manager registry.
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->class = 'GloryUserBundle:OAuth';
        $this->em = $registry->getManager();
        $this->repository = $this->em->getRepository($this->class);
    }

    /**
     * @param array $criteria
     *
     * @return object
     */
    protected function findUser(array $criteria)
    {
        if (null === $this->repository) {
            $this->repository = $this->em->getRepository($this->class);
        }
        $oauth = $this->repository->findOneBy($criteria);
        return $oauth ? $oauth->getUser() : $oauth;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = $this->findUser(array('username' => $username));
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
        $resourceOwnerName = $response->getResourceOwner()->getName();
        $criteria = array('owner' => $resourceOwnerName, 'username' => $response->getUsername());
        if (null == $user = $this->findUser($criteria)) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $response->getNickname()));
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->class || is_subclass_of($class, $this->class);
    }

}
