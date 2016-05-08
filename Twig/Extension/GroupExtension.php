<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Group
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupExtension extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('group', array($this, 'getGroup')),
            new \Twig_SimpleFunction('groups', array($this, 'getGroups')),
        );
    }

    public function getGroup($name)
    {
        $manager = $this->getGroupManager();
        return $manager->findGroupByName($name);
    }

    public function getGroups()
    {
        return $manager = $this->getGroupManager()->findGroups();
    }

    protected function getGroupManager()
    {
        return $this->container->get('glory_user.group_manager');
    }

    public function getName()
    {
        return 'glory_user.group_extension';
    }

}
