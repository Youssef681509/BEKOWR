<?php

namespace App\Entity\FieldExtension;

use Doctrine\ORM\Mapping as ORM;

trait TimestampTrait {

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $extCode = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $updateAt = null; 

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $obs = null;
    
    #[ORM\PrePersist]
    public function initCreatedAt(): static 
    {
        $this->createdAt = new \DateTime('NOW');

        return $this;
    }
    
    #[ORM\PreUpdate]
    public function initUpdatedAt(): static 
    {
        $this->updateAt = new \DateTime('NOW');

        return $this;
    }

    public function getExtCode(): ?string 
    {
        return $this->extCode;
    }

    public function setExtCode(string $extCode): static 
    {
        $this->extCode = $extCode;

        return $this;
    }

    public function getCreatedAt(): \DateTime 
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static 
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdateAt(): ?\DateTime 
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTime $updateAt): static 
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getObs(): ?string 
    {
        return $this->obs;
    }

    public function setObs(string $obs): static 
    {
        $this->obs = $obs;

        return $this;
    }

}