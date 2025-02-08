<?php

namespace App\Entity;

use App\Entity\FieldExtension\CommonField;
use App\Entity\FieldExtension\TimestampTrait;
use App\Repository\BankRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BankRepository::class)]
class Bank
{
    use CommonField;
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $agency = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $npcontact = null;

    #[ORM\ManyToOne(inversedBy: 'banks')]
    private ?Cities $city = null;

    
    public function setnpcontact(string $npcontact): static 
    {
        $this->npcontact = $npcontact;

        return $this;
    }

    public function getnpcontact(): ?string
    {
        return $this->npcontact;
    }
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgency(): ?string 
    {
        return $this->agency;
    }

    public function setAgency(string $agency): static 
    {
        $this->agency = $agency;

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
