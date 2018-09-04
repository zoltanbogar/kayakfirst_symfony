<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('club');
        $builder->add('first_name');
        $builder->add('last_name');
        $builder->add('artOfPaddling');
        $builder->add('bodyWeight');
        $builder->add('email', EmailType::class, [
                'constraints' => [
                    new Email(),
                    new NotBlank(),
                    new Length([
                        'min' => 5,
                        'max' => 255
                    ])
                ]
            ]);
        $builder->add('password', PasswordType::class, array(
            'label' => 'form.password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => true,
        ));
        $builder->remove('username');
        $builder->remove('current_password');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_profile_form_type';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

}

