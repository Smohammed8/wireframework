<?php

namespace App\Entity;

use App\Repository\JobTitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobTitleRepository::class)]
class JobTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'jobTitles')]
    private ?JobTitleCategory $jobTitleCategory = null;

    #[ORM\ManyToOne(inversedBy: 'jobTitles')]
    private ?EducationalLevel $minEducationalRequirment = null;

    #[ORM\OneToMany(mappedBy: 'jobTitle', targetEntity: JobTitleFields::class)]
    private Collection $jobTitleFields;

    #[ORM\OneToMany(mappedBy: 'jobTitle', targetEntity: Position::class)]
    private Collection $positions;

    #[ORM\ManyToOne(inversedBy: 'jobTitles')]
    private ?Level $level = null;

    public function __construct()
    {
        $this->jobTitleFields = new ArrayCollection();
        $this->positions = new ArrayCollection();
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

    public function getJobTitleCategory(): ?JobTitleCategory
    {
        return $this->jobTitleCategory;
    }

    public function setJobTitleCategory(?JobTitleCategory $jobTitleCategory): self
    {
        $this->jobTitleCategory = $jobTitleCategory;

        return $this;
    }

    public function getMinEducationalRequirment(): ?EducationalLevel
    {
        return $this->minEducationalRequirment;
    }

    public function setMinEducationalRequirment(?EducationalLevel $minEducationalRequirment): self
    {
        $this->minEducationalRequirment = $minEducationalRequirment;

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
            $jobTitleField->setJobTitle($this);
        }

        return $this;
    }

    public function removeJobTitleField(JobTitleFields $jobTitleField): self
    {
        if ($this->jobTitleFields->removeElement($jobTitleField)) {
            // set the owning side to null (unless already changed)
            if ($jobTitleField->getJobTitle() === $this) {
                $jobTitleField->setJobTitle(null);
            }
        }

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
            $position->setJobTitle($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getJobTitle() === $this) {
                $position->setJobTitle(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }
}
