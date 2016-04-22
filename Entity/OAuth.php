<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Glory\Bundle\UserBundle\Model\OAuth as BaseOAuth;
use Glory\Bundle\UserBundle\Entity\User;

/**
 * OAuth
 *
 * @ORM\Table(name="user_oauth")
 * @ORM\Entity
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
class OAuth extends BaseOAuth
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=32)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var integer
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     * 
     */
    private $realname;

    /**
     * @var integer
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=255)
     */
    private $accesstoken;

    /**
     * @var string
     *
     * @ORM\Column(name="refresh_token", type="string", length=255, nullable=true)
     */
    private $refreshtoken;

    /**
     * @var string
     *
     * @ORM\Column(name="token_secret", type="string", length=255, nullable=true)
     */
    private $tokensecret;

    /**
     * @var string
     *
     * @ORM\Column(name="expires", type="integer", nullable=true)
     */
    private $expires;

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="integer", nullable=true)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="updated", type="integer", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="oauths")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->updated = time();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $owner
     *
     * @return UserOAuth
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return UserOAuth
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return UserOAuth
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return UserOAuth
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return UserOAuth
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set realname
     *
     * @param string $realname
     *
     * @return UserOAuth
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UserOAuth
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return UserOAuth
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
     * Set accesstoken
     *
     * @param string $accesstoken
     *
     * @return UserOAuth
     */
    public function setAccesstoken($accesstoken)
    {
        $this->accesstoken = $accesstoken;

        return $this;
    }

    /**
     * Get accesstoken
     *
     * @return string
     */
    public function getAccesstoken()
    {
        return $this->accesstoken;
    }

    /**
     * Set refreshtoken
     *
     * @param string $refreshtoken
     *
     * @return UserOAuth
     */
    public function setRefreshtoken($refreshtoken)
    {
        $this->refreshtoken = $refreshtoken;

        return $this;
    }

    /**
     * Get refreshtoken
     *
     * @return string
     */
    public function getRefreshtoken()
    {
        return $this->refreshtoken;
    }

    /**
     * Set tokensecret
     *
     * @param string $tokensecret
     *
     * @return UserOAuth
     */
    public function setTokensecret($tokensecret)
    {
        $this->tokensecret = $tokensecret;

        return $this;
    }

    /**
     * Get tokensecret
     *
     * @return string
     */
    public function getTokensecret()
    {
        return $this->tokensecret;
    }

    /**
     * Set expires
     *
     * @param integer $expires
     *
     * @return UserOAuth
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return integer
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set created
     *
     * @param integer $created
     *
     * @return UserOAuth
     */
    public function setCreated($created = null)
    {
        $this->created = $created? : time();

        return $this;
    }

    /**
     * Get created
     *
     * @return integer
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     *
     * @return UserOAuth
     */
    public function setUpdated($updated = null)
    {
        $this->updated = $updated? : time();

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return UserOAuth
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

}
