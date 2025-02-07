<?php

namespace App\Twig\Components;

use App\Entity\Bank;
use App\Form\BankType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class BankForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public ?Bank $bank = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(BankType::class, $this->bank);
    }
}
