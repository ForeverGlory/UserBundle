<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Model;

use FOS\UserBundle\Model\Group as FOSGroup;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Description of Group
 * 
 * @UniqueEntity("name")
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Group extends FOSGroup
{

    /**
     * @Assert\NotBlank()
     */
    protected $name;
    protected $createdTime;
    protected $updateTime;

    /**
     * Set createdTime
     *
     * @param integer $createdTime
     *
     * @return User
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * Get createdTime
     *
     * @return integer
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * Set updatedTime
     *
     * @param integer $updatedTime
     *
     * @return User
     */
    public function setUpdatedTime($updatedTime)
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    /**
     * Get updatedTime
     *
     * @return integer
     */
    public function getUpdatedTime()
    {
        return $this->updatedTime;
    }

}
