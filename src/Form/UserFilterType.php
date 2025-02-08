<?php

namespace App\Form;

use App\Entity\FilterData\UserFilter;
use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => '']
            ])
            // ->add('role', EntityType::class, [
            //     'class' => Role::class,
            //     'label' => false,
            //     'choice_label' => 'description',
            //     'autocomplete' => true,
            // ])
            // ->add('agency', AgencyAutocompleteField::class, [
            //     'label' => false,
            //     'placeholder' => 'Nom de l\'agence'
            // ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Actif' => true,
                    'Inactif' => true,
                ],
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserFilter::class
        ]);
    }
}
