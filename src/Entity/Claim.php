<?php

namespace App\Entity;

use App\Entity\FieldExtension\TimestampTrait;
use App\Repository\ClaimRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ClaimRepository::class)]
class Claim
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Beneficiary $beneficiary = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateClaim = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateClosing = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $typeOfClaim = null;

    #[ORM\Column(nullable: true)]
    private ?float $amount = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $passwordClaim = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Donor $donor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeneficiary(): ?Beneficiary
    {
        return $this->beneficiary;
    }

    public function setBeneficiary(?Beneficiary $beneficiary): static
    {
        $this->beneficiary = $beneficiary;

        return $this;
    }

    public function getDateClaim(): ?\DateTimeInterface
    {
        return $this->dateClaim;
    }

    public function setDateClaim(?\DateTimeInterface $dateClaim): static
    {
        $this->dateClaim = $dateClaim;

        return $this;
    }

    public function getDateClosing(): ?\DateTimeInterface
    {
        return $this->dateClosing;
    }

    public function setDateClosing(?\DateTimeInterface $dateClosing): static
    {
        $this->dateClosing = $dateClosing;

        return $this;
    }

    public function getTypeOfClaim(): ?string
    {
        return $this->typeOfClaim;
    }

    public function setTypeOfClaim(?string $typeOfClaim): static
    {
        $this->typeOfClaim = $typeOfClaim;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPasswordClaim(): ?string
    {
        return $this->passwordClaim;
    }

    public function setPasswordClaim(?string $passwordClaim): static
    {
        $this->passwordClaim = $passwordClaim;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDonor(): ?Donor
    {
        return $this->donor;
    }

    public function setDonor(?Donor $donor): static
    {
        $this->donor = $donor;

        return $this;
    }
}
