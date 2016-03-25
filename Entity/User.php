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
     * @ORM\Column(name="payPassword", type="string", length=64, nullable=true)
     */
    protected $paypassword;

    /**
     * @var string
     *
     * @ORM\Column(name="payPasswordSalt", type="string", length=64, nullable=true)
     */
    protected $paypasswordsalt;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setup", type="boolean", nullable=true)
     */
    protected $setup;

    /**
     * @var integer
     *
     * @ORM\Column(name="loginTime", type="integer", nullable=true)
     */
    protected $logintime;

    /**
     * @var string
     *
     * @ORM\Column(name="loginIp", type="string", length=64, nullable=true)
     */
    protected $loginip;

    /**
     * @var integer
     *
     * @ORM\Column(name="createdTime", type="integer", nullable=true)
     */
    protected $createdtime;

    /**
     * @var string
     *
     * @ORM\Column(name="createdIp", type="string", length=64, nullable=true)
     */
    protected $createdip;

    /**
     * @var string
     *
     * @ORM\Column(name="createdSource", type="string", length=64, nullable=true)
     */
    protected $createdsource;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedTime", type="integer", nullable=true)
     */
    protected $updatedtime;

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
     * Set paypassword
     *
     * @param string $paypassword
     *
     * @return User
     */
    public function setPaypassword($paypassword)
    {
        $this->paypassword = $paypassword;

        return $this;
    }

    /**
     * Get paypassword
     *
     * @return string
     */
    public function getPaypassword()
    {
        return $this->paypassword;
    }

    /**
     * Set paypasswordsalt
     *
     * @param string $paypasswordsalt
     *
     * @return User
     */
    public function setPaypasswordsalt($paypasswordsalt)
    {
        $this->paypasswordsalt = $paypasswordsalt;

        return $this;
    }

    /**
     * Get paypasswordsalt
     *
     * @return string
     */
    public function getPaypasswordsalt()
    {
        return $this->paypasswordsalt;
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
     * Set setup
     *
     * @param boolean $setup
     *
     * @return User
     */
    public function setSetup($setup)
    {
        $this->setup = $setup;

        return $this;
    }

    /**
     * Get setup
     *
     * @return boolean
     */
    public function getSetup()
    {
        return $this->setup;
    }

    /**
     * Set logintime
     *
     * @param integer $logintime
     *
     * @return User
     */
    public function setLogintime($logintime)
    {
        $this->logintime = $logintime;

        return $this;
    }

    /**
     * Get logintime
     *
     * @return integer
     */
    public function getLogintime()
    {
        return $this->logintime;
    }

    /**
     * Set loginip
     *
     * @param string $loginip
     *
     * @return User
     */
    public function setLoginip($loginip)
    {
        $this->loginip = $loginip;

        return $this;
    }

    /**
     * Get loginip
     *
     * @return string
     */
    public function getLoginip()
    {
        return $this->loginip;
    }

    /**
     * Set createdip
     *
     * @param string $createdip
     *
     * @return User
     */
    public function setCreatedip($createdip)
    {
        $this->createdip = $createdip;

        return $this;
    }

    /**
     * Get createdip
     *
     * @return string
     */
    public function getCreatedip()
    {
        return $this->createdip;
    }

    /**
     * Set createdtime
     *
     * @param integer $createdtime
     *
     * @return User
     */
    public function setCreatedtime($createdtime)
    {
        $this->createdtime = $createdtime;

        return $this;
    }

    /**
     * Get createdtime
     *
     * @return integer
     */
    public function getCreatedtime()
    {
        return $this->createdtime;
    }

    /**
     * Set createdsource
     *
     * @param string $createdsource
     *
     * @return User
     */
    public function setCreatedsource($createdsource)
    {
        $this->createdsource = $createdsource;

        return $this;
    }

    /**
     * Get createdsource
     *
     * @return string
     */
    public function getCreatedsource()
    {
        return $this->createdsource;
    }

    /**
     * Set updatedtime
     *
     * @param integer $updatedtime
     *
     * @return User
     */
    public function setUpdatedtime($updatedtime)
    {
        $this->updatedtime = $updatedtime;

        return $this;
    }

    /**
     * Get updatedtime
     *
     * @return integer
     */
    public function getUpdatedtime()
    {
        return $this->updatedtime;
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
