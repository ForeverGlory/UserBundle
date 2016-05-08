<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Model;

use FOS\UserBundle\Model\Group as FOSGroup;

/**
 * Description of Group
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Group extends FOSGroup
{

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
