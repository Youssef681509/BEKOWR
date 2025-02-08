<?php

namespace App\Form\Common;


use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

trait ConfigurationFieldTrait
{

//    private Security $security;
//    private string $authorized;
//
//    public function setRoles(Security $security): void {
//        $this->security = $security;
//    }
//
//    public function setAutorized(string $role): void {
//        $this->authorized = $role;
//    }
//
//    private function getRoles(): array {
//
//        $roles = $this->security->getUser()->getRoles();
//
//        return $roles;
//    }
//
//    public function isDisabled(): bool {
////        dd(array_search($this->getRoles(), [$this->authorized]));
//        if(in_array($this->authorized, $this->getRoles())){
//            return false;
//        }
//
//        return true;
//    }

    public function getConfiguration(
        string|bool $label,
        string $placeholder = null,
        bool $required = true,
        bool $readonly = false,
        bool $choiceEnable = false,
        string $class = '',
        array $constraints = []
    ): array {
        return [
            'label' => $label,
            'required' => $required,
            'empty_data' => '',
            'attr' => [
                'class' => $class,
                'placeholder' => $placeholder,
                'readonly' => $readonly,
                'style' => $choiceEnable ? 'height: 46px' : ''
            ],
            'constraints' => $constraints,
//            'disabled' => $this->isDisabled()
        ];
    }

    public function getConfigurationWithAttr(
        string|bool $label,
        bool $required = true,
        array $attr = [],
        array $constraints = []
    ): array {

        return [
            'label' => $label,
            'required' => $required,
            'empty_data' => '',
            'attr' => $attr,
            'constraints' => $constraints
        ];
    }
}
