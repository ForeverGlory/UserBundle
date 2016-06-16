<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Install;

use Glory\Executor\Bundle\ContainerAwareMission;
use Glory\Bundle\UserBundle\Model\GroupManager;
use FOS\UserBundle\Model\UserInterface;

/**
 * Description of GroupInstall
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupInstall extends ContainerAwareMission
{

    public function getPriority()
    {
        return 1;
    }

    public function isValid()
    {
        $groupManager = $this->getGroupManager();
        return $groupManager->findGroupByName('admin') ? false : true;
    }

    public function execute()
    {
        $groupManager = $this->getGroupManager();
        $group = $groupManager->createGroup('admin');
        $group->addRole('ROLE_ADMIN');
        $groupManager->updateGroup($group);
    }

    /**
     * @return GroupManager
     */
    protected function getGroupManager()
    {
        return $this->getContainer()->get('glory_user.group_manager');
    }

}
