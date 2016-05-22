<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <https://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\GroupFormType as BaseGroupFormType;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Description of GroupFormType
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class GroupFormType extends BaseGroupFormType
{

    use ContainerAwareTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $choices = array();
        $hierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        foreach ($hierarchy as $role => $hierarchy) {
            $choices[$role] = $role . ' (' . implode(',', $hierarchy) . ')';
        }
        $builder->add('roles', ChoiceType::class, array(
            'choices' => $choices,
            'expanded' => true,
            'multiple' => true,
            'label' => 'form.group_roles',
            'translation_domain' => 'GloryUserBundle'
        ));
    }

    public function getName()
    {
        return 'glory_user_group';
    }

}
