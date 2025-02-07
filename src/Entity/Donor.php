<?php

namespace App\Entity;

use App\Entity\FieldExtension\CommonField;
use App\Entity\FieldExtension\TimestampTrait;
use App\Repository\DonorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: DonorRepository::class)]
class Donor
{
    use CommonField;
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 140, nullable: true)]
    private ?string $bankAddress = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $npdonor = null;

    #[ORM\ManyToOne(inversedBy: 'donors')]
    private ?Cities $city = null;

    /**
     * @var Collection<int, Donation>
     */
    #[ORM\OneToMany(targetEntity: Donation::class, mappedBy: 'donor', orphanRemoval: true)]
    private Collection $donations;

    /**
     * @var Collection<int, Claim>
     */
    #[ORM\OneToMany(targetEntity: Claim::class, mappedBy: 'donor', orphanRemoval: true)]
    private Collection $claims;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->claims = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankAddress(): ?string
    {
        return $this->bankAddress;
    }

    public function setBankAddress(?string $bankAddress): static
    {
        $this->bankAddress = $bankAddress;

        return $this;
    }

    public function setnpdonor(string $npdonor): static 
    {
        $this->npdonor = $npdonor;

        return $this;
    }

    public function getnpdonor(): ?string
    {
        return $this->npdonor;
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
            $donation->setDonor($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): static
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getDonor() === $this) {
                $donation->setDonor(null);
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
            $claim->setDonor($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): static
    {
        if ($this->claims->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getDonor() === $this) {
                $claim->setDonor(null);
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
