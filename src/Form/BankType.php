<?php

namespace App\Form;

use App\Entity\Bank;
use App\Form\Common\ConfigurationFieldTrait;
use App\Form\EventSubscriber\CountryFilterSubscriber;
use Symfony\Component\DependencyInjection\Loader\Configurator\Traits\ConfiguratorTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Country;
use App\Entity\Cities;
use App\Entity\Countries;

class BankType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', TextType::class, $this->getConfiguration('Nom/ Raison Social', 'Nom/ Raison Social'))
            ->add('address', TextType::class, $this->getConfiguration('Adresse', 'Adresse'))
            ->add('country', EntityType::class, [
                'class' => Countries::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un pays',
                'mapped' => true,
                'required' => true,
                'attr' => [
                    'class' => 'country-select', //  JS fonctionne
                ],
            ])
            ->add('city', EntityType::class, [
                'class' => Cities::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une ville',
                'required' => true,
                'mapped' => true,
                'attr' => [
                    'class' => 'city-select', // JS fonctionne
                ],
            ])



            ->add('npcontact', TextType::class, [
                'label' => 'Nom -Prenom contact',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 430px;', 
                    'maxlength' => 100 
                ],
            ])
            ->add('agency', TextType::class, $this->getConfiguration('Agence'))
            ->add('phone1', TextType::class, $this->getConfiguration('Téléphone 1',''))
            ->add('phone2', TextType::class, $this->getConfiguration('Téléphone 2', required: false))
            ->add('phone3', TextType::class, $this->getConfiguration('Téléphone 3', required: false))
            ->add('fax', TextType::class, $this->getConfiguration('Fax', 'Fax : 1234...', required: false))
            ->add('mail', EmailType::class, $this->getConfiguration('Email', 'email@domain.com', required: false))
            ->add('location', TextType::class, $this->getConfiguration('Localisation', 'Localisation', required: false))
            ->add('rib', TextType::class, $this->getConfiguration('RIB', 'RIB'))
            ->add('obs', TextareaType::class, $this->getConfiguration('Observation', 'Ecrivez ici...', required: false))
        ;

        $builder->addEventSubscriber(new CountryFilterSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bank::class,
        ]);
    }
}
