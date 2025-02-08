<?php

namespace App\Entity;
//YGH
use App\Entity\Beneficiary;
//
use App\Entity\FieldExtension\TimestampTrait;
use App\Repository\DonationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Donor $donor = null;

    //#[ORM\ManyToOne(inversedBy: 'donations')]
    //#[ORM\JoinColumn(nullable: false)]
    //private ?Beneficiary $beneficiary = null;

    #[ORM\ManyToOne(targetEntity: Beneficiary::class)]
    #[ORM\JoinColumn(nullable: false)]  // Une donation doit toujours avoir un bénéficiaire
    private ?Beneficiary $beneficiary = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfDonation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfReceipt = null;

    #[ORM\Column(nullable: true)]
    private ?float $donAmount = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $donCurrency = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $statusOfDonation = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $passwordDon = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeneficiary(): ?Beneficiary
    {
        return $this->beneficiary;
    }

    public function setBeneficiary(?Beneficiary $beneficiary): static
    {
        $this->beneficiary = $beneficiary;

        return $this;
    }

    public function getDateOfDonation(): ?\DateTimeInterface
    {
        return $this->dateOfDonation;
    }

    public function setDateOfDonation(?\DateTimeInterface $dateOfDonation): static
    {
        $this->dateOfDonation = $dateOfDonation;

        return $this;
    }

    public function getDateOfReceipt(): ?\DateTimeInterface
    {
        return $this->dateOfReceipt;
    }

    public function setDateOfReceipt(?\DateTimeInterface $dateOfReceipt): static
    {
        $this->dateOfReceipt = $dateOfReceipt;

        return $this;
    }

    public function getDonAmount(): ?float
    {
        return $this->donAmount;
    }

    public function setDonAmount(?float $donAmount): static
    {
        $this->donAmount = $donAmount;

        return $this;
    }

    public function getDonCurrency(): ?string
    {
        return $this->donCurrency;
    }

    public function setDonCurrency(?string $donCurrency): static
    {
        $this->donCurrency = $donCurrency;

        return $this;
    }

    public function getStatusOfDonation(): ?string
    {
        return $this->statusOfDonation;
    }

    public function setStatusOfDonation(?string $statusOfDonation): static
    {
        $this->statusOfDonation = $statusOfDonation;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPasswordDon(): ?string
    {
        return $this->passwordDon;
    }

    public function setPasswordDon(?string $passwordDon): static
    {
        $this->passwordDon = $passwordDon;

        return $this;
    }
}
