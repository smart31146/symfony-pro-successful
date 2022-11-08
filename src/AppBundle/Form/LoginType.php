<?php
/**
 * Created by PhpStorm.
 * User: harmakit
 * Date: 10/11/2018
 * Time: 13:49
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Username',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'form-control',
                    'pattern' => '.{3,}'
                ],
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'min' => 3
                    ])
                ]
            ])
        ;
    }
}