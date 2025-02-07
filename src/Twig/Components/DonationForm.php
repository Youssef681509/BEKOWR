<?php

namespace App\Twig\Components;

use App\Entity\Donation;
use App\Form\DonationType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class DonationForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public ?Donation $donation = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DonationType::class, $this->donation);
    }
}
