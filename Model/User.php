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

use FOS\UserBundle\Model\User as FOSUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Description of User
 *
 * @UniqueEntity(
 *      fields="usernameCanonical",
 *      errorPath="username",
 *      message="fos_user.username.already_used",
 *      groups={"Register","Profile"}
 * )
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
class User extends FOSUser implements UserInterface
{

    /**
     * @Assert\NotBlank(message="fos_user.username.blank", groups={"Register", "Profile"})
     * @Assert\Length(min=2, minMessage="fos_user.username.short", max=16, maxMessage="fos_user.username.long", groups={"Register","Profile"})
     */
    protected $username;

    /**
     * @Assert\Email(message="fos_user.email.invalid", groups={"Register","Profile"})
     */
    protected $email;

    /**
     * @Assert\NotBlank(message="fos_user.password.blank", groups={"Register","ResetPassword","ChangePassword"})
     * @Assert\Length(min=6, minMessage="fos_user.password.short", max=32, groups={"Register","Profile","ResetPassword","ChangePassword"})
     */
    protected $plainPassword;
    protected $avatar;
    protected $loginTime;
    protected $loginIp;
    protected $createdTime;
    protected $createdIp;
    protected $createdSource;
    protected $updateTime;
    protected $profile;

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
        return $this->avatar? : '/bundles/gloryuser/images/avatar.jpg';
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
     * Set profile
     *
     * @param Profile $profile
     *
     * @return User
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get Profile
     * 
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    public function __call($method, $arguments)
    {
        $profile = $this->getProfile();
        if ($profile && method_exists($profile, $method)) {
            return call_user_method_array($method, $profile, $arguments);
        }
    }
    
    public function getRoles()
    {
        $roles = parent::getRoles();
        foreach($roles as $key => $role){
            if(is_string($role)){
                $roles[$key] = new \Glory\Bundle\UserBundle\Security\Role\Role($role);
            }
        }
        return $roles;
    }

}
