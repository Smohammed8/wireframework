<?php

namespace App\Entity;

use App\Repository\AgreementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgreementRepository::class)]
class Agreement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'agreement', targetEntity: Indigent::class)]
    private Collection $indigents;

    #[ORM\OneToMany(mappedBy: 'agreement', targetEntity: Woreda::class)]
    private Collection $woredas;

    public function __construct()
    {
        $this->indigents = new ArrayCollection();
        $this->woredas = new ArrayCollection();
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

    /**
     * @return Collection<int, Indigent>
     */
    public function getIndigents(): Collection
    {
        return $this->indigents;
    }

    public function addIndigent(Indigent $indigent): self
    {
        if (!$this->indigents->contains($indigent)) {
            $this->indigents->add($indigent);
            $indigent->setAgreement($this);
        }

        return $this;
    }

    public function removeIndigent(Indigent $indigent): self
    {
        if ($this->indigents->removeElement($indigent)) {
            // set the owning side to null (unless already changed)
            if ($indigent->getAgreement() === $this) {
                $indigent->setAgreement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Woreda>
     */
    public function getWoredas(): Collection
    {
        return $this->woredas;
    }

    public function addWoreda(Woreda $woreda): self
    {
        if (!$this->woredas->contains($woreda)) {
            $this->woredas->add($woreda);
            $woreda->setAgreement($this);
        }

        return $this;
    }

    public function removeWoreda(Woreda $woreda): self
    {
        if ($this->woredas->removeElement($woreda)) {
            // set the owning side to null (unless already changed)
            if ($woreda->getAgreement() === $this) {
                $woreda->setAgreement(null);
            }
        }

        return $this;
    }
}
