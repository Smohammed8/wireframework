<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    private ?Grade $grade = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacity = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: SectionHead::class)]
    private Collection $sectionHeads;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: SubjectAssignment::class)]
    private Collection $subjectAssignments;

    #[ORM\Column(nullable: true)]
    private ?bool $isFunctional = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Registration::class)]
    private Collection $registrations;

    public function __construct()
    {
        $this->sectionHeads = new ArrayCollection();
        $this->subjectAssignments = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->getGrade().'- Section '.$this->name;
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, SectionHead>
     */
    public function getSectionHeads(): Collection
    {
        return $this->sectionHeads;
    }

    public function addSectionHead(SectionHead $sectionHead): static
    {
        if (!$this->sectionHeads->contains($sectionHead)) {
            $this->sectionHeads->add($sectionHead);
            $sectionHead->setSection($this);
        }

        return $this;
    }

    public function removeSectionHead(SectionHead $sectionHead): static
    {
        if ($this->sectionHeads->removeElement($sectionHead)) {
            // set the owning side to null (unless already changed)
            if ($sectionHead->getSection() === $this) {
                $sectionHead->setSection(null);
            }
        }

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
            $subjectAssignment->setSection($this);
        }

        return $this;
    }

    public function removeSubjectAssignment(SubjectAssignment $subjectAssignment): static
    {
        if ($this->subjectAssignments->removeElement($subjectAssignment)) {
            // set the owning side to null (unless already changed)
            if ($subjectAssignment->getSection() === $this) {
                $subjectAssignment->setSection(null);
            }
        }

        return $this;
    }

    public function isIsFunctional(): ?bool
    {
        return $this->isFunctional;
    }

    public function setIsFunctional(?bool $isFunctional): static
    {
        $this->isFunctional = $isFunctional;

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setSection($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getSection() === $this) {
                $registration->setSection(null);
            }
        }

        return $this;
    }
}
