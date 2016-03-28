<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * @author ForeverGlory <foreverglory@qq.com>
 */
class RegistrationListener implements EventSubscriberInterface
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
            FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm',
            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationConfirmed'
        );
    }

    public function onRegistrationInitialize(GetResponseUserEvent $event)
    {
        //note: 如何 $event->getResponse() 有值，将不继续注册，而直接返回 response.
        //note: 可用于限制注册功能
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $user->setCreatedIp($event->getRequest()->getClientIp());
        $user->setCreatedTime(time());
        //note: 如果 $event->getResponse() 有值，将不会跳转到注册成功页面，而继续执行 FOSUserEvents::REGISTRATION_COMPLETED
        //note: 注册成功
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        //note: 注册完成
    }

    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        //note: 如何 $event->getResponse() 有值，将不会跳转到注册成功页面，而继续执行 FOSUserEvents::REGISTRATION_CONFIRMED
        //note: 可用于邮箱认证、手机认证等
    }

    public function onRegistrationConfirmed(FilterUserResponseEvent $event)
    {
        //note: 确认完成
    }

}
