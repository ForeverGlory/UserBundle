<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SecurityController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class RegisterController extends Controller
{

    /**
     * 
     * @see parent::registerAction($request);
     */
    public function registerAction(Request $request)
    {
        return parent::registerAction($request);
    }

    /**
     * 
     * @see parent::confirmedAction()
     */
    public function confirmedAction(Request $request)
    {
        return parent::confirmedAction($request);
    }

    /**
     * 重新加载模板
     */
    public function render($view, array $parameters = array(), \Symfony\Component\HttpFoundation\Response $response = null)
    {
        switch ($view) {
            //用户注册
            case 'FOSUserBundle:Registration:register.html.twig':
                $view = 'GloryUserBundle::register.html.twig';
                break;
            //注册成功
            case 'FOSUserBundle:Registration:confirmed.html.twig':
                $view = 'GloryUserBundle:Register:success.html.twig';
                break;
        }
        return parent::render($view, $parameters, $response);
    }

}
