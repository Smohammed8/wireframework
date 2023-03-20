<?php

namespace App\Entity;

use App\Repository\RelationshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationshipRepository::class)]
class Relationship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $sex = null;

    #[ORM\OneToMany(mappedBy: 'relationship', targetEntity: EmergencyContact::class)]
    private Collection $emergencyContacts;

    #[ORM\OneToMany(mappedBy: 'relationship', targetEntity: EmployeeFamily::class)]
    private Collection $employeeFamilies;

    public function __construct()
    {
        $this->emergencyContacts = new ArrayCollection();
        $this->employeeFamilies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->name;
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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return Collection<int, EmergencyContact>
     */
    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContact $emergencyContact): self
    {
        if (!$this->emergencyContacts->contains($emergencyContact)) {
            $this->emergencyContacts->add($emergencyContact);
            $emergencyContact->setRelationship($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContact $emergencyContact): self
    {
        if ($this->emergencyContacts->removeElement($emergencyContact)) {
            // set the owning side to null (unless already changed)
            if ($emergencyContact->getRelationship() === $this) {
                $emergencyContact->setRelationship(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeFamily>
     */
    public function getEmployeeFamilies(): Collection
    {
        return $this->employeeFamilies;
    }

    public function addEmployeeFamily(EmployeeFamily $employeeFamily): self
    {
        if (!$this->employeeFamilies->contains($employeeFamily)) {
            $this->employeeFamilies->add($employeeFamily);
            $employeeFamily->setRelationship($this);
        }

        return $this;
    }

    public function removeEmployeeFamily(EmployeeFamily $employeeFamily): self
    {
        if ($this->employeeFamilies->removeElement($employeeFamily)) {
            // set the owning side to null (unless already changed)
            if ($employeeFamily->getRelationship() === $this) {
                $employeeFamily->setRelationship(null);
            }
        }

        return $this;
    }
}
