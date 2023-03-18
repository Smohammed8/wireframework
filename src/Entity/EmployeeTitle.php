<?php

namespace App\Entity;

use App\Repository\EmployeeTitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeTitleRepository::class)]
class EmployeeTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $accronomy = null;

    #[ORM\OneToMany(mappedBy: 'employeeTitle', targetEntity: Employee::class)]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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

    public function getAccronomy(): ?string
    {
        return $this->accronomy;
    }

    public function setAccronomy(string $accronomy): self
    {
        $this->accronomy = $accronomy;

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
            $employee->setEmployeeTitle($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getEmployeeTitle() === $this) {
                $employee->setEmployeeTitle(null);
            }
        }

        return $this;
    }
}
