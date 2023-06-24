<?php

namespace App\Entity;

use App\Repository\LeaveTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaveTypeRepository::class)]
class LeaveType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'leaveType', targetEntity: StudentLeave::class)]
    private Collection $studentLeaves;

    public function __construct()
    {
        $this->studentLeaves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, StudentLeave>
     */
    public function getStudentLeaves(): Collection
    {
        return $this->studentLeaves;
    }

    public function addStudentLeaf(StudentLeave $studentLeaf): static
    {
        if (!$this->studentLeaves->contains($studentLeaf)) {
            $this->studentLeaves->add($studentLeaf);
            $studentLeaf->setLeaveType($this);
        }

        return $this;
    }

    public function removeStudentLeaf(StudentLeave $studentLeaf): static
    {
        if ($this->studentLeaves->removeElement($studentLeaf)) {
            // set the owning side to null (unless already changed)
            if ($studentLeaf->getLeaveType() === $this) {
                $studentLeaf->setLeaveType(null);
            }
        }

        return $this;
    }
}
