<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'units')]
    private ?self $parentUnit = null;

    #[ORM\OneToMany(mappedBy: 'parentUnit', targetEntity: self::class)]
    private Collection $units;

    #[ORM\ManyToOne(inversedBy: 'units')]
    private ?Employee $leader = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: Position::class)]
    private Collection $positions;

    public function __construct()
    {
        $this->units = new ArrayCollection();
        $this->positions = new ArrayCollection();
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

    public function getParentUnit(): ?self
    {
        return $this->parentUnit;
    }

    public function setParentUnit(?self $parentUnit): self
    {
        $this->parentUnit = $parentUnit;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(self $unit): self
    {
        if (!$this->units->contains($unit)) {
            $this->units->add($unit);
            $unit->setParentUnit($this);
        }

        return $this;
    }

    public function removeUnit(self $unit): self
    {
        if ($this->units->removeElement($unit)) {
            // set the owning side to null (unless already changed)
            if ($unit->getParentUnit() === $this) {
                $unit->setParentUnit(null);
            }
        }

        return $this;
    }

    public function getLeader(): ?Employee
    {
        return $this->leader;
    }

    public function setLeader(?Employee $leader): self
    {
        $this->leader = $leader;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Position>
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->setUnit($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getUnit() === $this) {
                $position->setUnit(null);
            }
        }

        return $this;
    }
}
