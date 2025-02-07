<?php

namespace App\Form;

use App\Entity\Donor;
use Doctrine\ORM\Query;
use App\Entity\Donation;
use App\Entity\Beneficiary;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use App\Repository\BeneficiaryRepository;
use DateTime;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DonationType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function __construct(
        private BeneficiaryRepository $beneficiaryRepository,
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateOfDonation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date Donation'
            ])
            ->add('dateOfReceipt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de reception',
            ])
            ->add('donAmount', NumberType::class, $this->getConfiguration('Montant', '00.0'))
            ->add('donCurrency', TextType::class, $this->getConfiguration('Devise', 'exple: XAF'))
            // ->add('statusOfDonation', )
            ->add('paymentMethod', ChoiceType::class, [
                'choices' => [
                    'Carte visa' => 'carte_visa',
                    'Carte Virtuelle' => 'carte_virtuelle'
                ]
            ])
            ->add('donor', EntityType::class, [
                'class' => Donor::class,
                'choice_label' => 'companyName',
                'label' => 'Donateur'
            ])
            //YGH
            ->add ('beneficiary', EntityType::class, [
                    'class' => Beneficiary::class,
                    'choice_label' => function (Beneficiary $beneficiary) {
                           return $beneficiary->getFirstName() . ' ' . $beneficiary->getLastName();
                    },
                    //'choice_label' => 'first_name',
                    'label' => 'Nom & Prenom du Beneficiaire'
                    ])

            //->add ('beneficiary', EntityType::class, [
                       // 'class' => Beneficiary::class,
                      //  'choice_label' => 'first_name',
                       // 'label' => 'Prenom Bénéficiaire'
                        //])
        
            
          
          
            //->add('beneficiary', EntityType::class, [
                //'class' => Beneficiary::class,
                //'choices' => $this->beneficiaryRepository->findActiveBeneficiaries(),
                //'choice_label' => 'Beneficiaires', 
                //'placeholder' => 'Sélectionnez un bénéficiaire',
               // 'required' => true,
           //])
            //YGH
            //->add('beneficiary', TextType::class, $this->getConfiguration('Beneficiaire'))
            // ->add('beneficiary', EntityType::class, [
            //     'class' => Beneficiary::class,
            //     'query_builder' => function(EntityRepository $er): QueryBuilder {
            //         return $er->createQueryBuilder('b0')
            //             ->where('b0.enable = :status')
            //             ->setParameter(':status', true)
            //             ;
            //     },
            //     'choice_label' => 'companyName',
            //     'label' => 'Beneficière',
             //])
            ->add('obs', TextareaType::class, $this->getConfigurationWithAttr('Observation', required: false,
                attr: [
                    'placeholder' => 'Ecrivez ici...',
                    'rows' => 4,
                ]))
        ;

        //$builder->get('dateOfDonation')->addEventListener(FormEvents::PRE_SUBMIT, 
            //function(FormEvent $event):void {

                //$data = $event->getData();
                //$form = $event->getForm();

                //if(!is_null($data) || !empty($data)) 
                //{
                    //$form->getParent()->add('beneficiary', EntityType::class, [
                        //'class' => Beneficiary::class,
                        //'query_builder' => $this->findBeneficiaryActif(new \DateTime($data)),
                        //choice_label' => 'companyName',
                        //'label' => 'Beneficière',
                    //]);
                //}
           // });
    }

    private function findBeneficiaryActif(\DateTimeInterface $dateOfDon): QueryBuilder {
        return $this->beneficiaryRepository->createQueryBuilder('b0')
            ->where('b0.enable = :status')
            ->andWhere('b0.donSrvStrDate >= :dateOfDon')
            ->setParameter(':status', true)
            ->setParameter(':dateOfDon', $dateOfDon)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
