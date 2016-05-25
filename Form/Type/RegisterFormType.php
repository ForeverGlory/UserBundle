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

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of RegisterFormType
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class RegisterFormType extends RegistrationFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('email');
    }

    public function getName()
    {
        return 'glory_user_register';
    }

}
