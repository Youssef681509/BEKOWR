<?php

namespace App\Twig\Components;

use App\Entity\Donor;
use App\Form\DonorType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class DonorForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'somethingElse')]
    public ?Donor $donor = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DonorType::class, $this->donor);
    }
}
