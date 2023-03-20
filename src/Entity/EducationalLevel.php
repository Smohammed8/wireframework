<?php

namespace App\Entity;

use App\Repository\EducationalLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationalLevelRepository::class)]
class EducationalLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'educationallevel', targetEntity: Employee::class)]
    private Collection $employees;

    #[ORM\OneToMany(mappedBy: 'minEducationalRequirment', targetEntity: JobTitle::class)]
    private Collection $jobTitles;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->jobTitles = new ArrayCollection();
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

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setEducationallevel($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getEducationallevel() === $this) {
                $employee->setEducationallevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobTitle>
     */
    public function getJobTitles(): Collection
    {
        return $this->jobTitles;
    }

    public function addJobTitle(JobTitle $jobTitle): self
    {
        if (!$this->jobTitles->contains($jobTitle)) {
            $this->jobTitles->add($jobTitle);
            $jobTitle->setMinEducationalRequirment($this);
        }

        return $this;
    }

    public function removeJobTitle(JobTitle $jobTitle): self
    {
        if ($this->jobTitles->removeElement($jobTitle)) {
            // set the owning side to null (unless already changed)
            if ($jobTitle->getMinEducationalRequirment() === $this) {
                $jobTitle->setMinEducationalRequirment(null);
            }
        }

        return $this;
    }
}
