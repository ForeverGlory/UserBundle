<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * check register
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class RegisterPass implements CompilerPassInterface
{

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formType = 'fos_user.registration.form.type';
        if ($container->hasParameter($formType)) {
            $value = $container->getParameter($formType);
            if ($value == 'fos_user_registration') {
                $container->setParameter($formType, 'glory_user_register');
            }
        }

        $formName = 'fos_user.registration.form.name';
        if ($container->hasParameter($formName)) {
            $value = $container->getParameter($formName);
            if ($value == 'fos_user_registration_form') {
                $container->setParameter($formName, 'user');
            }
        }

        $formName = 'fos_user.registration.form.validation_groups';
        if ($container->hasParameter($formName)) {
            $groups = $container->getParameter($formName);
            if (in_array('Registration', $groups)) {
                $key = array_search('Registration', $groups);
                $groups[$key] = 'Register';
                $container->setParameter($formName, $groups);
            }
        }
    }

}
