<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserWithoutPasswordType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles')
            ->add('code', TextType::class, $this->getConfiguration('Code', 'Auto Generate', required: false, readonly: true))
            ->add('extCode', TextType::class, $this->getConfiguration('Code Externe'))
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom(s)'))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom(s)'))
            ->add('birthDay', DateType::class, [
                'label' => 'Date de Naissance',
                'format' => 'dd-MM-yyyy',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'date-widget']
            ])
            // ->add('password', RepeatedType::class, [
            //     'type' => PasswordType::class,
            //     'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
            //     'options' => ['attr' => ['class' => 'password-field']],
            //     'required' => true,
            //     'first_options'  => ['label' => 'Mot de passe'],
            //     'second_options' => ['label' => 'Confirmer le mot de passe'],
            // ])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays',
                'choices' => [
                    'Congo' => 'COG',
                    'RDC Congo' => 'COD',

                ],
                'attr' => ['class' => 'js-choice-1'],
            ])
            ->add('city', ChoiceType::class, [
                'label' => 'Ville',
                'choices' => [
                    'Brazzaville' => 'BZ',
                    'Pointe-Noire' => 'PN',
                ],
                'attr' => ['class' => 'js-choice-2'],
            ])
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'Ex : nom@email.com'))
            ->add('address', TextType::class, $this->getConfiguration('Adresse', required: false))
            ->add('phone1', TextType::class, $this->getConfiguration('Téléphone 1', required: false))
            ->add('phone2', TextType::class, $this->getConfiguration('Téléphone 2', required: false))
            ->add('eanable', CheckboxType::class, [
                'label' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('userRoles', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'description',
                // 'expanded' => true,
                'multiple' => true,
                'label' => 'Rôle Utilisateurs',
                'autocomplete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
