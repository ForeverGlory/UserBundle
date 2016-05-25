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

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of Profile
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Profile
{

    protected $user;
    protected $avatar;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function __call($method, $arguments)
    {
        
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

}
