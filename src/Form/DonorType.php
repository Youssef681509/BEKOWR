<?php

namespace App\Form;


use App\Entity\Bank;
use App\Entity\Country;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Donor;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\EventSubscriber\CountryFilterSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;  


class DonorType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function __construct(
       private readonly EntityManagerInterface $manager
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', TextType::class, $this->getConfiguration('Nom/ Raison Social', 'Nom/ Raison Social'))
            ->add('address', TextType::class, $this->getConfiguration('Adresse', 'Adresse'))
            //->add('bankAddress', TextType::class, $this->getConfiguration('Adresse de la banque', ''))
            ->add('npdonor', TextType::class, [
                'label' => 'Nom -Prenom contact du donateur',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 430px;', 
                    'maxlength' => 100 
                ],
            ])
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
            
            ->add('phone1', TextType::class, $this->getConfiguration('Téléphone 1',''))
            ->add('phone2', TextType::class, $this->getConfiguration('Téléphone 2', required: false))
            ->add('phone3', TextType::class, $this->getConfiguration('Téléphone 3', required: false))
            ->add('fax', TextType::class, $this->getConfiguration('Fax', 'Fax : 1234...', required: false))
            ->add('mail', EmailType::class, $this->getConfiguration('Email', 'email@domain.com', required: false))
            ->add('location', TextType::class, $this->getConfiguration('Localisation', 'Localisation'))
            ->add('rib', TextType::class, $this->getConfiguration('RIB', 'RIB'))
            ->add('obs', TextareaType::class,  $this->getConfigurationWithAttr('Observation', required: false,
                attr: [
                    'rows' => 4,
                ]))

             ->add('bank', EntityType::class, [
                    'class' => Bank::class,
                    'choice_label' => 'company_name', // Le champ 'name' de l'entité Bank sera affiché
                    'placeholder' => 'Choisissez une banque', // Optionnel : valeur par défaut
                ])
        ;
        
         $builder->addEventSubscriber(new CountryFilterSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donor::class,
        ]);
    }
}
