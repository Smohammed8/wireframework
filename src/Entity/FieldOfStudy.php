<?php

namespace App\Entity;

use App\Repository\FieldOfStudyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldOfStudyRepository::class)]
class FieldOfStudy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'fieldOfStudy', targetEntity: Employee::class)]
    private Collection $employees;

    #[ORM\OneToMany(mappedBy: 'fieldOfStudy', targetEntity: JobTitleFields::class)]
    private Collection $jobTitleFields;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->jobTitleFields = new ArrayCollection();
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
            $employee->setFieldOfStudy($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getFieldOfStudy() === $this) {
                $employee->setFieldOfStudy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobTitleFields>
     */
    public function getJobTitleFields(): Collection
    {
        return $this->jobTitleFields;
    }

    public function addJobTitleField(JobTitleFields $jobTitleField): self
    {
        if (!$this->jobTitleFields->contains($jobTitleField)) {
            $this->jobTitleFields->add($jobTitleField);
            $jobTitleField->setFieldOfStudy($this);
        }

        return $this;
    }

    public function removeJobTitleField(JobTitleFields $jobTitleField): self
    {
        if ($this->jobTitleFields->removeElement($jobTitleField)) {
            // set the owning side to null (unless already changed)
            if ($jobTitleField->getFieldOfStudy() === $this) {
                $jobTitleField->setFieldOfStudy(null);
            }
        }

        return $this;
    }
}
