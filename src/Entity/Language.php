<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isLocal = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: EmployeeLanguage::class)]
    private Collection $employeeLanguages;

    public function __construct()
    {
        $this->employeeLanguages = new ArrayCollection();
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

    public function isIsLocal(): ?bool
    {
        return $this->isLocal;
    }

    public function setIsLocal(bool $isLocal): self
    {
        $this->isLocal = $isLocal;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeLanguage>
     */
    public function getEmployeeLanguages(): Collection
    {
        return $this->employeeLanguages;
    }

    public function addEmployeeLanguage(EmployeeLanguage $employeeLanguage): self
    {
        if (!$this->employeeLanguages->contains($employeeLanguage)) {
            $this->employeeLanguages->add($employeeLanguage);
            $employeeLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeEmployeeLanguage(EmployeeLanguage $employeeLanguage): self
    {
        if ($this->employeeLanguages->removeElement($employeeLanguage)) {
            // set the owning side to null (unless already changed)
            if ($employeeLanguage->getLanguage() === $this) {
                $employeeLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
