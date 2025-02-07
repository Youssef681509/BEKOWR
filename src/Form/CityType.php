<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Countries;
use App\Form\Common\ConfigurationFieldTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration('ville', 'nom de la ville'))
            ->add('latitude', NumberType::class, $this->getConfiguration('latitude', 'latitude'))
            ->add('longitude', NumberType::class, $this->getConfiguration('latitude', 'latitude'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cities::class,
        ]);
    }
}
