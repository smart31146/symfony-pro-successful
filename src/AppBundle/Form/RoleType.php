<?php
/**
 * Created by PhpStorm.
 * User: harmakit
 * Date: 10/11/2018
 * Time: 13:49
 */

namespace AppBundle\Form;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotNull;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Name',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('accesses',CollectionType::class,array(
                'entry_type' => AccessType::class,
                'entry_options' => [
                    'label' => false
                ],
                'attr' => [
                    'style' => 'padding-left: 3%;'
                ],
                'label' => 'Accesses',
                'delete_empty' => true,
                'required' => false,
                'by_reference' => false
            ))
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Users',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'username',
                'attr' => [
                    'placeholder' => 'Users',
                    'class' => 'form-control form-group',
                    'style' => 'width: 80%'
                ],
                'required' => false,
                'by_reference' => false,
                'query_builder' => function(UserRepository $userRepository) {
                    return $userRepository->findAllQB();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Role::class
        ));
    }
}