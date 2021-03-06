<?php namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GoogleRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, [
                    'constraints' => [
                        new NotBlank()
                    ],
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Password Confirmation'],
                    'invalid_message' => 'The entered passwords don\'t match',
                ]
            )
            ->add('birthDate', BirthdayType::class, array(
                'attr' => array('class' => 'birthday-picker'),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'required' => false,
            ))
            ->add('bodyWeight', NumberType::class)
            ->add('country', CountryType::class, array(
                'placeholder' => 'Choose country',
            ))
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'empty_data' => null,
                'placeholder' => 'Choose your gender',
            ])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-block save'),
                'label' => 'Register',
            ))
            ->add('club', TextType::class, [
                'required' => false,
            ])
            ->add('artOfPaddling', TextType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'app_facebook_reg_type';
    }
}
