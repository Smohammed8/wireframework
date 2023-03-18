<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionRepository::class)]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'positions')]
    private ?Unit $unit = null;

    #[ORM\ManyToOne(inversedBy: 'positions')]
    private ?JobTitle $jobTitle = null;

    #[ORM\Column]
    private ?int $NoOfVacants = null;

    #[ORM\OneToMany(mappedBy: 'position', targetEntity: PositionCode::class)]
    private Collection $positionCodes;

    #[ORM\OneToMany(mappedBy: 'position', targetEntity: Employee::class)]
    private Collection $employees;

    public function __construct()
    {
        $this->positionCodes = new ArrayCollection();
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getJobTitle(): ?JobTitle
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?JobTitle $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getNoOfVacants(): ?int
    {
        return $this->NoOfVacants;
    }

    public function setNoOfVacants(int $NoOfVacants): self
    {
        $this->NoOfVacants = $NoOfVacants;

        return $this;
    }

    /**
     * @return Collection<int, PositionCode>
     */
    public function getPositionCodes(): Collection
    {
        return $this->positionCodes;
    }

    public function addPositionCode(PositionCode $positionCode): self
    {
        if (!$this->positionCodes->contains($positionCode)) {
            $this->positionCodes->add($positionCode);
            $positionCode->setPosition($this);
        }

        return $this;
    }

    public function removePositionCode(PositionCode $positionCode): self
    {
        if ($this->positionCodes->removeElement($positionCode)) {
            // set the owning side to null (unless already changed)
            if ($positionCode->getPosition() === $this) {
                $positionCode->setPosition(null);
            }
        }

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
            $employee->setPosition($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getPosition() === $this) {
                $employee->setPosition(null);
            }
        }

        return $this;
    }
}
