<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Agency;
use App\Entity\Counter;
use Doctrine\ORM\QueryBuilder;
use App\Repository\CounterRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\AbstractType;
use App\Form\Common\ConfigurationFieldTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    use ConfigurationFieldTrait;

    public function __construct(
        private Security $security,
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $this->setRoles($this->security);
//        $this->setAutorized('ROLE_SUP');

//        dd($this->isDisabled());

        $builder
            // ->add('roles')
//            ->add('code', TextType::class, $this->getConfiguration('Code', 'Auto Generate', false, true))
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom(s)'))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom(s)'))
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'email@domain.com'))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ;
//             ->add('birthDay', DateType::class, [
//                 'label' => 'Date de Naissance',
//                 'format' => 'dd-MM-yyyy',
//                 'widget' => 'single_text',
//                 'html5' => false,
//                 'attr' => ['class' => 'flatpickr'],
// //                'disabled' => $this->isDisabled($this->getRoles())
//             ])
//             ->add('userRoles', EntityType::class, [
//                 'class' => Role::class,
//                 'choice_label' => 'description',
//                 // 'expanded' => true,
//                 'multiple' => true,
//                 'label' => 'Rôle Utilisateurs',
//                 'autocomplete' => true,
// //                'disabled' => $this->isDisabled($this->getRoles())
//             ])
//             ->add('city', ChoiceType::class, [
//                 'label' => 'Pays',
//                 'choices' => [
//                     'Congo' => 'COG',
//                     'RDC Congo' => 'COD',

//                 ],
//                 'attr' => ['class' => 'js-choice-1'],
// //                'disabled' => $this->isDisabled($this->getRoles())
//             ])
//             ->add('country', ChoiceType::class, [
//                 'label' => 'Ville',
//                 'required' => false,
//                 'choices' => [
//                     'Brazzaville' => 'BZ',
//                     'Pointe-Noire' => 'PN',
//                 ],
//                 'attr' => ['class' => 'js-choice-2'],
// //                'disabled' => $this->isDisabled($this->getRoles())
//             ])
    

        // $builder->get('agency')->addEventListener(
        //     FormEvents::PRE_SUBMIT,
        //   function(FormEvent $event){
        //         $form = $event->getForm();
        //         $data = $event->getData();
        //         if(!empty($data)) {
        //             $roles = $this->extractRoleName($form->getParent()->get('userRoles')->getData());

        //             if (in_array('ROLE_PDV', $roles) || in_array('ROLE_POS', $roles))
        //             {

        //                 $form->getParent()->add('counter', EntityType::class, [
        //                     'class' => Counter::class,
        //                     'choice_label' => 'name',
        //                     'label' => 'Guichet',
        //                     'autocomplete' => true,
        //                     'query_builder' => $this->filterByAgencyId((int)$data)
        //                 ]);
        //             }
        //         }
        //   }
        // );

        // $builder->addEventListener(
        //     FormEvents::POST_SET_DATA,
        //     function(FormEvent $event): void {
        //         $form = $event->getForm();
        //         $data = $event->getForm();

        //         if ($data !== null){

        //             $user = $data->getViewData();
        //             $counter = $user->getCounter();

        //             if($counter !== null){
        //                 $form->get('agency')
        //                     ->setData(
        //                         $counter->getBranch());

        //                 $form->add('counter', EntityType::class, [
        //                     'class' => Counter::class,
        //                     'choice_label' => 'name',
        //                     'label' => 'Caisse',
        //                     'autocomplete' => true,
        //                     'query_builder' => $this->filterByAgencyId($form->get('agency')->getData()->getId())
        //                 ]);
        //             }
        //         }
        //     }
        // );
    }

    /**
     * @param ArrayCollection|PersistentCollection $roles
     * @return array
     */
    private function extractRoleName(ArrayCollection|PersistentCollection $roles): array {

        $roleNames = [];

        if($roles instanceof PersistentCollection){
            foreach ($roles as $role){
                $roleNames[] = $role->getName();
            }
        }

        if($roles instanceof ArrayCollection){
            $roleNames = $roles->map(function ($role) {
                return $role->getName();
            });

            return $roleNames->toArray();
        }

        return $roleNames;
    }

    /**
     * @param int $agency_id
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function filterByAgencyId(int $agency_id): QueryBuilder {
        return $this->counterRepository->createQueryBuilder('c0')
            ->join('c0.branch', 'a0')
            ->where('a0.id = :agency_id')
            ->andWhere('c0.eanable = true')
            ->setParameter(':agency_id', $agency_id);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
