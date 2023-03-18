<?php

namespace App\Entity;

use App\Repository\EmployeeLanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeLanguageRepository::class)]
class EmployeeLanguage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employeeLanguages')]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(inversedBy: 'employeeLanguages')]
    private ?Language $language = null;

    #[ORM\Column(length: 50)]
    private ?string $speaking = null;

    #[ORM\Column(length: 50)]
    private ?string $reading = null;

    #[ORM\Column(length: 50)]
    private ?string $writing = null;

    #[ORM\Column(length: 50)]
    private ?string $listening = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getSpeaking(): ?string
    {
        return $this->speaking;
    }

    public function setSpeaking(string $speaking): self
    {
        $this->speaking = $speaking;

        return $this;
    }

    public function getReading(): ?string
    {
        return $this->reading;
    }

    public function setReading(string $reading): self
    {
        $this->reading = $reading;

        return $this;
    }

    public function getWriting(): ?string
    {
        return $this->writing;
    }

    public function setWriting(string $writing): self
    {
        $this->writing = $writing;

        return $this;
    }

    public function getListening(): ?string
    {
        return $this->listening;
    }

    public function setListening(string $listening): self
    {
        $this->listening = $listening;

        return $this;
    }
}
