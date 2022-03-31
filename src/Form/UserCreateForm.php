<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserCreateForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'placeholder' => 'First Name ...',
                    'class' => 'input100',
                    'autofocus' => true
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Last Name ...',
                    'class' => 'input100',
                    'autofocus' => true
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'abc@xyz.com ...',
                    'class' => 'input100',
                    'autofocus' => true
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'input100',
                    'autofocus' => true
                ]
            ])
        ;
    }
}
