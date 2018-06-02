<?php
/**
 * Created by PhpStorm.
 * User: pandrey
 * Date: 30/05/2018
 * Time: 16:31
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('dateOfBirth', BirthdayType::class)
            ->add('sex', ChoiceType::class, [
                'choices' => ['male' => 'masc', 'female' => 'fem']
            ])
            ->add('country', CountryType::class)
            ->add('city', TextType::class)
            ->add('save', SubmitType::class, array(
                'label' => 'enroll'))
        ;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => User::class,
//        ));
//    }
}