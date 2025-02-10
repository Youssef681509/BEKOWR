<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Beneficiary;
use App\Entity\Cities;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use App\Form\EventSubscriber\CountryFilterSubscriber;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;




class BeneficiaryType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom(s)'))
            //->add('histo', TextType::class, $this->getConfiguration('Historique de donations'))
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Encours' => 'encours',
                    'Accepté' => 'accepté',
                    'Refusé' => 'refusé',
                ],
                'placeholder' => 'Sélectionnez un statut',
                'required' => true,
            ])
            ->add('histo', TextType::class, [
                'label' => 'Historique de donations',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 180px;', 
                    'maxlength' => 15 
                ],
            ])
            ->add('placeOfBirth', EntityType::class, [
                'class' => Cities::class,
                'choice_label' => 'name', 
                'placeholder' => 'Choisir une ville',
                'label' => 'Lieu de naissance',
            ])
            ->add('lastName', TextType::class, $this->getConfiguration('Nom(s)'))
            ->add('city', TextType::class, $this->getConfiguration('Ville'))
            //->add('civility', TextType::class, $this->getConfiguration('Civilité'))
            // Mettre Civilité sous forme de liste YGH 04/02/2025
            //->add('civility', TextType::class, $this->getConfiguration('Civilité'))
            ->add('civility', ChoiceType::class, [
                'choices' => [
                    'M.' => 'M.',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle',
            
                ],
                'label' => 'Titre de civilité'
            ])
            
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'anniversaire'
            ])
            //->add('placeOfBirth', TypeTextType::class, $this->getConfiguration('Lieu de naissance'))
            ->add('titleOfIdDoc', ChoiceType::class, [
                'choices' => [
                    'CNI' => 'CNI',
                    'NIU' => 'NIU',
                    'Passeport' => 'PP',
                    'Autre a préciser' => 'OT'
                ],
                'label' => 'Titre pièce d\'identité'
            ])
            ->add('naturePieceIdentite', TextType::class, [
                'required' => false,
                'label' => 'Nature pièce d\'identité',
                'attr' => [
                    'class' => 'naturePieceIdentite'
                ]
            ])
            ->add('idNumber', TextType::class, $this->getConfiguration('Numéro pièce d\'identité'))
            ->add('donSrvStrDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début de services de donation',
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Personne physique' => 'PP',
                    'Personne morale' => 'PM'
                ],
                'label' => 'Catégorie'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Ménage' => 'MN',
                    'Individuelle' => 'IND'
                ]
            ])
            ->add('elecIdDoc', FileType::class, [
                'label' => 'Pièce d\'identité format electronique',
                'mapped' => false,
                'required' => false,
                'constraints' => [new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Svp télécharger un fichier pdf valide',
                ])]
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Etat',
                'required' => false,
            ])
            ->add('cardType', ChoiceType::class, [
                'choices' => [
                    'Carte Visa' => 'carte_visa',
                    'Carte virtuelle' => 'carte_virtuelle',
                ],
                'label' => 'Type de carte'
            ])
            ->add('address', TextType::class, $this->getConfiguration('Adresse'))
            ->add('country',CountriesAutocompleteField::class, [
                'mapped' => false,
                'label' => 'Pays',
                'placeholder' => 'Choisir un pays'
            ])
            ->add('phone1', TextType::class, $this->getConfiguration('Téléphone 1'))
            ->add('phone2', TextType::class, $this->getConfiguration('Téléphone 2'))
            ->add('phone3', TextType::class, $this->getConfiguration('Téléphone 3'))
            ->add('fax', TextType::class, $this->getConfiguration('Fax', '123'))
            ->add('mail', TextType::class, $this->getConfiguration('Email', 'email@domain.com'))
            ->add('location', TextType::class, $this->getConfiguration('Localisation'))
            ->add('rib', TextType::class, $this->getConfiguration('RIB'))
            //->add('enable2', CheckboxType::class, [
            //    'label' => 'Statut',
            //    'required' => false,
            //])
            ->add('obs', TextareaType::class, 
                $this->getConfigurationWithAttr('Observation', required: false,
                attr: [
                    'rows' => 4,
                ]))
        ;

         $builder->addEventSubscriber(new CountryFilterSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiary::class,
        ]);
    }
}
 