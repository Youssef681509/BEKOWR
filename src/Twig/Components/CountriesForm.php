<?php

namespace App\Twig\Components;

use App\Entity\Countries;
use App\Form\CountriesType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class CountriesForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'somethingElse')]
    public ?Countries $countries = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CountriesType::class, $this->countries);
    }

    #[LiveAction]
    public function addCity()
    {
        // "formValues" represents the current data in the form
        // this modifies the form to add an extra comment
        // the result: another embedded comment form!
        // change "comments" to the name of the field that uses CollectionType
        $this->formValues['cities'][] = [];
    }

    #[LiveAction]
    public function removeCity(#[LiveArg] int $index)
    {
        unset($this->formValues['cities'][$index]);
    }
}
