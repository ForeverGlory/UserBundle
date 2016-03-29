<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use FOS\UserBundle\Model\User as FOSUser;
use Doctrine\Common\Collections\ArrayCollection;
use Glory\Bundle\UserBundle\Entity\Group;
use Glory\Bundle\UserBundle\Entity\OAuth;

/**
 * User
 * 
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @AttributeOverrides({
 *      @AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              nullable = true
 *          )
 *      ),
 *      @AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical",
 *              nullable = true,
 *              unique   = false
 *          )
 *      ),
 *      @AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              name     = "password",
 *              nullable = true
 *          )
 *      )
 * })
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
class User extends FOSUser
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * @var integer
     *
     * @ORM\Column(name="loginTime", type="integer", nullable=true)
     */
    protected $loginTime;

    /**
     * @var string
     *
     * @ORM\Column(name="loginIp", type="string", length=64, nullable=true)
     */
    protected $loginIp;

    /**
     * @var integer
     *
     * @ORM\Column(name="createdTime", type="integer", nullable=true)
     */
    protected $createdTime;

    /**
     * @var string
     *
     * @ORM\Column(name="createdIp", type="string", length=64, nullable=true)
     */
    protected $createdIp;

    /**
     * @var string
     *
     * @ORM\Column(name="createdSource", type="string", length=64, nullable=true)
     */
    protected $createdSource;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedTime", type="integer", nullable=true)
     */
    protected $updatedTime;

    /**
     * @ORM\OneToMany(targetEntity="OAuth", mappedBy="user")
     */
    protected $oauths;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="user_group_relation",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    public function __construct()
    {
        parent::__construct();
        $this->oauths = new ArrayCollection();
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set loginTime
     *
     * @param integer $loginTime
     *
     * @return User
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;

        return $this;
    }

    /**
     * Get loginTime
     *
     * @return integer
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set loginIp
     *
     * @param string $loginIp
     *
     * @return User
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;

        return $this;
    }

    /**
     * Get loginIp
     *
     * @return string
     */
    public function getLoginIp()
    {
        return $this->loginIp;
    }

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
     * Set createdIp
     *
     * @param string $createdIp
     *
     * @return User
     */
    public function setCreatedIp($createdIp)
    {
        $this->createdIp = $createdIp;

        return $this;
    }

    /**
     * Get createdIp
     *
     * @return string
     */
    public function getCreatedIp()
    {
        return $this->createdIp;
    }

    /**
     * Set createdSource
     *
     * @param string $createdSource
     *
     * @return User
     */
    public function setCreatedSource($createdSource)
    {
        $this->createdSource = $createdSource;

        return $this;
    }

    /**
     * Get createdSource
     *
     * @return string
     */
    public function getCreatedSource()
    {
        return $this->createdSource;
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

    /**
     * Add oauth
     *
     * @param \Glory\Bundle\UserBundle\Entity\OAuth $oauth
     *
     * @return User
     */
    public function addOauth(\Glory\Bundle\UserBundle\Entity\OAuth $oauth)
    {
        $this->oauths[] = $oauth;

        return $this;
    }

    /**
     * Remove oauth
     *
     * @param \Glory\Bundle\UserBundle\Entity\OAuth $oauth
     */
    public function removeOauth(\Glory\Bundle\UserBundle\Entity\OAuth $oauth)
    {
        $this->oauths->removeElement($oauth);
    }

    /**
     * Get oauths
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOauths()
    {
        return $this->oauths;
    }
}
