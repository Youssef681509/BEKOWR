<?php

namespace App\Twig\Components;

use App\Entity\Claim;
use App\Form\ClaimType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
final class ClaimForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'somethingElse')]
    public ?Claim $claim = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ClaimType::class, $this->claim);
    }
}
