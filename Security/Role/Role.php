<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Security\Role;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Description of Role
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Role implements RoleInterface, \Serializable
{

    private $role;

    /**
     * Constructor.
     *
     * @param string $role The role name
     */
    public function __construct($role)
    {
        $this->role = (string) $role;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->role;
    }

    public function serialize()
    {
        return serialize(array(
            $this->role
        ));
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list($this->role) = $data;
    }

}
