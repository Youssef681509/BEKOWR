<?php

namespace App\Twig\Components;

use App\Entity\Beneficiary;
use App\Form\BeneficiaryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent]
final class BeneficiaryForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'somethingElse')]
    public ?Beneficiary $beneficiary = null;

    protected function instantiateForm(): FormInterface
    {
            return $this->createForm(BeneficiaryType::class, $this->beneficiary);
    }
}
