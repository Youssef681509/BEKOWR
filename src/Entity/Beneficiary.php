<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\FieldExtension\CommonField;
use App\Entity\FieldExtension\TimestampTrait;
use App\Repository\BeneficiaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BeneficiaryRepository::class)]
class Beneficiary
{
    use CommonField;
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 7, scale: 2, options: ["default" => 0])]
        private ?string $histo = "0.00";
    
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 40)]
    private ?string $civility = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    //#[ORM\Column(length: 140, nullable: true)]
    //private ?string $placeOfBirth = null;

    #[ORM\Column(length: 17, nullable: true)]
    private ?string $titleOfIdDoc = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $idNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $donSrvStrDate = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $elecIdDoc = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enable = null;

    // src/Entity/Beneficiary.php
    //
    #[ORM\ManyToOne(targetEntity: Cities::class)]
    #[ORM\JoinColumn(nullable: false)]

    //

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $status = null;
    
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    public function setStatus(?string $status): static
    {
        $this->status = $status;
    
        return $this;
    }
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $naturePieceIdentite = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $cardType = null;

    #[ORM\ManyToOne(inversedBy: 'beneficiaries')]
    private ?Cities $city = null;

    /**
     * @var Collection<int, Donation>
     */
    #[ORM\OneToMany(targetEntity: Donation::class, mappedBy: 'beneficiary', orphanRemoval: true)]
    private Collection $donations;

    /**
     * @var Collection<int, Claim>
     */
    #[ORM\OneToMany(targetEntity: Claim::class, mappedBy: 'beneficiary', orphanRemoval: true)]
    private Collection $claims;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->claims = new ArrayCollection();
    }
// 0802

    private ?Cities $placeOfBirth = null;
   
    public function getNaturePieceIdentite(): ?string
    {
        return $this->naturePieceIdentite;
    }

    public function setNaturePieceIdentite(?string $naturePieceIdentite): self
    {
        $this->naturePieceIdentite = $naturePieceIdentite;

        return $this;
    }
    

    public function getplaceOfBirth(): ?Cities
    {
    return $this->placeOfBirth;
    }

    public function setplaceOfBirth(?Cities $placeOfBirth): static
    {
    $this->placeOfBirth = $placeOfBirth;
    return $this;
    }
//
     public function gethisto(): ?string {
         return $this->histo;
      }

    public function sethisto(?string $histo): self {
         $this->histo = $histo;
         return $this;
       }

//
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }


   
    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

        public function getTitleOfIdDoc(): ?string
    {
        return $this->titleOfIdDoc;
    }

    public function setTitleOfIdDoc(?string $titleOfIdDoc): static
    {
        $this->titleOfIdDoc = $titleOfIdDoc;

        return $this;
    }

    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    public function setIdNumber(?string $idNumber): static
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    public function getDonSrvStrDate(): ?\DateTimeInterface
    {
        return $this->donSrvStrDate;
    }

    public function setDonSrvStrDate(?\DateTimeInterface $donSrvStrDate): static
    {
        $this->donSrvStrDate = $donSrvStrDate;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getElecIdDoc(): ?string
    {
        return $this->elecIdDoc;
    }

    public function setElecIdDoc(?string $elecIdDoc): static
    {
        $this->elecIdDoc = $elecIdDoc;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(?string $cardType): static
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * @return Collection<int, Donation>
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): static
    {
        if (!$this->donations->contains($donation)) {
            $this->donations->add($donation);
            $donation->setBeneficiary($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): static
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getBeneficiary() === $this) {
                $donation->setBeneficiary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Claim>
     */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    public function addClaim(Claim $claim): static
    {
        if (!$this->claims->contains($claim)) {
            $this->claims->add($claim);
            $claim->setBeneficiary($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): static
    {
        if ($this->claims->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getBeneficiary() === $this) {
                $claim->setBeneficiary(null);
            }
        }

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): static
    {
        $this->city = $city;

        return $this;
    }
}
