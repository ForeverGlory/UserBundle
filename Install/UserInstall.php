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

/**
 * Description of UserInstall
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserInstall extends ContainerAwareMission
{

    public function isValid()
    {
        $user = $this->getUserManager()->findUserByUsername('admin');
        return $user ? false : true;
    }

    public function execute()
    {
        $group = $this->getContainer()->get('glory_user.group_manager')->findGroupByName('admin');
        $userManager = $this->getUserManager();
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setPlainPassword('letmein');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->addGroup($group);
        $userManager->updateUser($user);
    }

    protected function getUserManager()
    {
        return $this->getContainer()->get('glory_user.user_manager');
    }

}
