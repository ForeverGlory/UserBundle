<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Glory\Bundle\UserBundle\Model\User;
use Glory\Bundle\UserBundle\Model\OAuth;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Description of UserManager
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserManager
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getUserClass()
    {
        return 'Glory\\Bundle\\UserBundle\\Entity\\User';
    }

    protected function getOAuthClass()
    {
        return 'Glory\\Bundle\\UserBundle\\Entity\\OAuth';
    }

    public function findOAuth($criteria = array())
    {
        $repository = $this->getDoctrine()->getRepository($this->getOAuthClass());
        return $repository->findOneBy($criteria);
    }

    public function findOAuthByUser(User $user)
    {
        return $this->findOAuth(array('user' => $user));
    }

    /**
     * 
     * @param UserResponseInterface $response
     * @return OAuth
     */
    public function createOAuthFromResponse(UserResponseInterface $response)
    {
        $oauthClass = $this->getOAuthClass();
        $oauth = new $oauthClass();
        $oauth->setOwner($response->getResourceOwner()->getName());
        $oauth->setUsername($response->getUsername());
        $oauth->setCreated();
        $this->updateOAuthFromResponse($oauth, $response, true);
        return $oauth;
    }

    /**
     * 
     * @param OAuth $oauth
     * @param UserResponseInterface $response
     * @return OAuth
     */
    public function updateOAuthFromResponse(OAuth $oauth, UserResponseInterface $response = null, $andFlush = false)
    {
        $oauth->setNickname($response->getNickname());
        $oauth->setFirstname($response->getFirstName());
        $oauth->setLastname($response->getLastName());
        $oauth->setRealname($response->getRealName());
        $oauth->setEmail($response->getEmail());
        $oauth->setAvatar($response->getProfilePicture());
        $oauth->setAccesstoken($response->getAccessToken());
        $oauth->setRefreshtoken($response->getRefreshToken());
        $oauth->setTokensecret($response->getTokenSecret());
        $oauth->setExpires($response->getExpiresIn());
        $this->updateOAuth($oauth, $andFlush);
    }

    public function updateOAuth(OAuth $oauth, $andFlush = true)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($oauth);
        if ($andFlush) {
            $em->flush();
        }
    }

    public function bindOAuth(User $user, OAuth $oauth)
    {
        $oauth->setUser($user);
        $this->updateOAuth($oauth, true);
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
