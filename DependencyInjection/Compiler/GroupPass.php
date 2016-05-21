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
 * check group
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupPass implements CompilerPassInterface
{

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formType = 'fos_user.group.form.type';
        if ($container->hasParameter($formType)) {
            $value = $container->getParameter($formType);
            if ($value == 'fos_user_group') {
                $container->setParameter($formType, 'glory_user_group');
            }
        }

        $formName = 'fos_user.group.form.name';
        if ($container->hasParameter($formName)) {
            $value = $container->getParameter($formName);
            if ($value == 'fos_user_group_form') {
                $container->setParameter($formName, 'group');
            }
        }
    }

}
