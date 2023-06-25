<?php

namespace App\Entity;

use App\Repository\SectionHeadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionHeadRepository::class)]
class SectionHead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sectionHeads')]
    private ?Section $section = null;

    #[ORM\ManyToOne(inversedBy: 'sectionHeads')]
    private ?User $head = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function getHead(): ?User
    {
        return $this->head;
    }

    public function setHead(?User $head): static
    {
        $this->head = $head;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }
}
