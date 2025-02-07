<?php

namespace App\Form;

use App\Entity\Countries;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class CountriesType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, $this->getConfiguration('Code', 'ex CG'))
            ->add('name', TextType::class, $this->getConfiguration('Nom', 'Nom'))
            ->add('cities',  LiveCollectionType::class, [
                     'entry_type' => CityType::class,
                     'allow_add' => true,
                     'allow_delete' => true,
                     'label' => false,
                     'by_reference' => false,
                 ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Countries::class,
        ]);
    }
}
