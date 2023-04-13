<?php

namespace App\Entity;

use App\Repository\WoredaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WoredaRepository::class)]
class Woreda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'woredas')]
    private ?Zone $zone = null;

    #[ORM\OneToMany(mappedBy: 'woreda', targetEntity: Patient::class)]
    private Collection $patients;

    #[ORM\ManyToOne(inversedBy: 'woredas')]
    private ?Agreement $agreement = null;

    #[ORM\Column]
    private ?bool $isAgreed = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setWoreda($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getWoreda() === $this) {
                $patient->setWoreda(null);
            }
        }

        return $this;
    }

    public function getAgreement(): ?Agreement
    {
        return $this->agreement;
    }

    public function setAgreement(?Agreement $agreement): self
    {
        $this->agreement = $agreement;

        return $this;
    }

    public function isIsAgreed(): ?bool
    {
        return $this->isAgreed;
    }

    public function setIsAgreed(bool $isAgreed): self
    {
        $this->isAgreed = $isAgreed;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
