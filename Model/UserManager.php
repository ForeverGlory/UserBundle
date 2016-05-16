<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * UserManager
 * 
 * extends 'fos_user.user_manager' service
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserManager implements UserManagerInterface
{

    protected $container;
    protected $class;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * 'fos_user.user_manager' -> $method
     * 
     * @param type $method
     * @param type $arguments
     * @return
     */
    public function __call($method, $arguments)
    {
        $userManager = $this->getFOSUserManager();
        if (method_exists($userManager, $method)) {
            return call_user_func_array(array($userManager, $method), $arguments);
        }
        throw new \LogicException(sprintf('%s method is not exists', $method));
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function getClass()
    {
        return $this->class? : $this->getFOSUserManager()->getClass();
    }

    /**
     * 查找用户
     * @param array $criteria
     * @param array $orderBy
     * @param type $limit
     * @param type $offset
     * @return Traversable
     */
    public function findUsers(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->getDoctrine()->getRepository($this->getClass());
        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @return \FOS\UserBundle\Model\UserManagerInterface
     */
    protected function getFOSUserManager()
    {
        return $this->container->get('fos_user.user_manager');
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }
        return $this->container->get('doctrine');
    }

}
