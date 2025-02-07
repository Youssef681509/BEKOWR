<?php

namespace App\Form\EventSubscriber;

use App\Entity\Cities;
use App\Entity\Countries;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CountryFilterSubscriber implements EventSubscriberInterface {


    public static function getSubscribedEvents(): array {

        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::POST_SET_DATA => 'onPostSetData'
        ];
    }

    public function onPreSubmit(FormEvent $event): void {
        $form = $event->getForm();
        $data = $event->getData();

        // dd($data);

        if(!empty($data)){

            $form->add('city', EntityType::class, [
                'class' => Cities::class,
                'label' => 'Ville',
                'choice_label' => 'name',
                'query_builder' => function(EntityRepository $er) use ($data) {

                    return $er->createQueryBuilder('c')
                        ->join('c.country', 'c1')
                        ->where('c1.id = :country_id')
                        ->setParameter(':country_id', (int)$data['country']);
                },

                'autocomplete' => true,
            ]);
        }
    }

    public function onPostSetData(FormEvent $event): void {
        $form = $event->getForm();
        $data = $form->getData();

        $entity = $form->getData();

        if($entity !== null) {

            if($entity->getCity() !== null){

                $form->get('country')->setData($data->getCity()->getCountry());

                $form->add('city', EntityType::class, [
                    'class' => Cities::class,
                    'label' => 'Ville',
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) use ($data) {

                        return $er->createQueryBuilder('c')
                            ->join('c.country', 'c1')
                            ->where('c1.id = :country_id')
                            ->setParameter(':country_id', (int)$data->getCity()->getCountry()->getId());
                        },

                        'autocomplete' => true,
                ]);
            }

        }
    }

}