<?php

namespace App\Entity;

use App\Repository\JobTitleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobTitleCategoryRepository::class)]
class JobTitleCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'jobTitleCategory', targetEntity: JobTitle::class)]
    private Collection $jobTitles;

    public function __construct()
    {
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
            $jobTitle->setJobTitleCategory($this);
        }

        return $this;
    }

    public function removeJobTitle(JobTitle $jobTitle): self
    {
        if ($this->jobTitles->removeElement($jobTitle)) {
            // set the owning side to null (unless already changed)
            if ($jobTitle->getJobTitleCategory() === $this) {
                $jobTitle->setJobTitleCategory(null);
            }
        }

        return $this;
    }
}
