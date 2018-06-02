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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\RequestDataHandler;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $countries = Intl::getRegionBundle()->getCountryNames();

        $countries = array_combine( $countries, $countries );

        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('dateOfBirth', BirthdayType::class)
            ->add('sex', ChoiceType::class, [
                'choices' => ['male' => 'male', 'female' => 'female']
            ])
            ->add('countryName', ChoiceType::class, [
                'choices' => array_flip($countries),
                'label'=>'Country'
            ])
            ->add('cityName', TextType::class)
            ->add('save', SubmitType::class, array(
                'label' => 'enroll'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RequestDataHandler::class,
        ));
    }
}