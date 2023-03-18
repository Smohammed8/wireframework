<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: JobTitle::class)]
    private Collection $jobTitles;

    public function __construct()
    {
        $this->jobTitles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }   public function __toString()
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
            $jobTitle->setLevel($this);
        }

        return $this;
    }

    public function removeJobTitle(JobTitle $jobTitle): self
    {
        if ($this->jobTitles->removeElement($jobTitle)) {
            // set the owning side to null (unless already changed)
            if ($jobTitle->getLevel() === $this) {
                $jobTitle->setLevel(null);
            }
        }

        return $this;
    }
}
