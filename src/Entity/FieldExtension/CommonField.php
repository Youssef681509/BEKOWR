<?php

namespace App\Entity\FieldExtension;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Validator\Constraints as Assert;


trait CommonField {

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 148, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone1 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone2 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone3 = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $location = null;

    #[Assert\Length(
        min: 24,
        max: 24,
        minMessage: 'Ce champs ne peut pas contenir moins de {{ limit }} caractère',
        maxMessage: 'Ce champs ne peut pas avoir plus de {{ limit }} caractère'
    )]
    #[ORM\Column(nullable: true, length: 24)]
    private ?string $rib = null;

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    public function setPhone1(?string $phone1): static
    {
        $this->phone1 = $phone1;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): static
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getPhone3(): ?string
    {
        return $this->phone3;
    }

    public function setPhone3(?string $phone3): static
    {
        $this->phone3 = $phone3;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): static
    {
        $this->rib = $rib;

        return $this;
    }

}