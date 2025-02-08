<?php

namespace App\Form;

use App\Entity\Beneficiary;
use App\Entity\Claim;
use App\Entity\Donor;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClaimType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateClaim', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date réclamation'
            ])
            ->add('dateClosing', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de cloture réclamation'
            ])
            ->add('typeOfClaim', ChoiceType::class, [
                'choices' => [
                    'Non reçue' => 'NR',
                    'Partiellement reçue' => 'PR',
                    'Erreur sur montant' => 'EM',
                    'Erreur sur banque' => 'EB',
                ],
                'label' => 'Type de Réclamation'
            ])
            ->add('amount', NumberType::class, $this->getConfiguration('Montant'))
            // ->add('passwordClaim')
            // ->add('status')
            ->add('beneficiary', EntityType::class, [
                'class' => Beneficiary::class,
                'choice_label' => 'companyName',
                'label' => 'Beneficiaire',
            ])
            ->add('donor', EntityType::class, [
                'class' => Donor::class,
                'choice_label' => 'companyName',
                'label' => 'Doneurs'
            ])
            ->add('obs', TextareaType::class, $this->getConfigurationWithAttr('Observation', required: false, 
                attr: [
                'rows' => 4
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Claim::class,
        ]);
    }
}
