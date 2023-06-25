<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subjects')]
    private ?Grade $grade = null;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: SubjectAssignment::class)]
    private Collection $subjectAssignments;

    public function __construct()
    {
        $this->subjectAssignments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name .' for '. $this->getGrade();
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

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection<int, SubjectAssignment>
     */
    public function getSubjectAssignments(): Collection
    {
        return $this->subjectAssignments;
    }

    public function addSubjectAssignment(SubjectAssignment $subjectAssignment): static
    {
        if (!$this->subjectAssignments->contains($subjectAssignment)) {
            $this->subjectAssignments->add($subjectAssignment);
            $subjectAssignment->setSubject($this);
        }

        return $this;
    }

    public function removeSubjectAssignment(SubjectAssignment $subjectAssignment): static
    {
        if ($this->subjectAssignments->removeElement($subjectAssignment)) {
            // set the owning side to null (unless already changed)
            if ($subjectAssignment->getSubject() === $this) {
                $subjectAssignment->setSubject(null);
            }
        }

        return $this;
    }
}
