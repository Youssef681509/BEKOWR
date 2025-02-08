<?php

namespace App\Entity;

use App\Repository\CitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitiesRepository::class)]
class Cities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'cities', cascade: ['persist', 'refresh', 'remove'])]
    private ?Countries $country = null;

    /**
     * @var Collection<int, Bank>
     */
    #[ORM\OneToMany(targetEntity: Bank::class, mappedBy: 'city')]
    private Collection $banks;

    public function __construct()
    {
        $this->banks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(?Countries $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Bank>
     */
    public function getBanks(): Collection
    {
        return $this->banks;
    }

    public function addBank(Bank $bank): static
    {
        if (!$this->banks->contains($bank)) {
            $this->banks->add($bank);
            $bank->setCity($this);
        }

        return $this;
    }

    public function removeBank(Bank $bank): static
    {
        if ($this->banks->removeElement($bank)) {
            // set the owning side to null (unless already changed)
            if ($bank->getCity() === $this) {
                $bank->setCity(null);
            }
        }

        return $this;
    }
}
