<?php

namespace App\Entity;

use App\Repository\SalaryScaleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalaryScaleRepository::class)]
class SalaryScale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Level $level = null;

    #[ORM\Column(length: 100)]
    private ?string $startSalary = null;

    #[ORM\Column(length: 100)]
    private ?string $one = null;

    #[ORM\Column(length: 100)]
    private ?string $two = null;

    #[ORM\Column(length: 100)]
    private ?string $three = null;

    #[ORM\Column(length: 100)]
    private ?string $four = null;

    #[ORM\Column(length: 100)]
    private ?string $five = null;

    #[ORM\Column(length: 100)]
    private ?string $six = null;

    #[ORM\Column(length: 100)]
    private ?string $seven = null;

    #[ORM\Column(length: 100)]
    private ?string $eight = null;

    #[ORM\Column(length: 100)]
    private ?string $nine = null;

    #[ORM\Column(length: 100)]
    private ?string $ceilSalary = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'salaryScales')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartSalary(): ?string
    {
        return $this->startSalary;
    }

    public function setStartSalary(string $startSalary): self
    {
        $this->startSalary = $startSalary;

        return $this;
    }

    public function getOne(): ?string
    {
        return $this->one;
    }

    public function setOne(string $one): self
    {
        $this->one = $one;

        return $this;
    }

    public function getTwo(): ?string
    {
        return $this->two;
    }

    public function setTwo(string $two): self
    {
        $this->two = $two;

        return $this;
    }

    public function getThree(): ?string
    {
        return $this->three;
    }

    public function setThree(string $three): self
    {
        $this->three = $three;

        return $this;
    }

    public function getFour(): ?string
    {
        return $this->four;
    }

    public function setFour(string $four): self
    {
        $this->four = $four;

        return $this;
    }

    public function getFive(): ?string
    {
        return $this->five;
    }

    public function setFive(string $five): self
    {
        $this->five = $five;

        return $this;
    }

    public function getSix(): ?string
    {
        return $this->six;
    }

    public function setSix(string $six): self
    {
        $this->six = $six;

        return $this;
    }

    public function getSeven(): ?string
    {
        return $this->seven;
    }

    public function setSeven(string $seven): self
    {
        $this->seven = $seven;

        return $this;
    }

    public function getEight(): ?string
    {
        return $this->eight;
    }

    public function setEight(string $eight): self
    {
        $this->eight = $eight;

        return $this;
    }

    public function getNine(): ?string
    {
        return $this->nine;
    }

    public function setNine(string $nine): self
    {
        $this->nine = $nine;

        return $this;
    }

    public function getCeilSalary(): ?string
    {
        return $this->ceilSalary;
    }

    public function setCeilSalary(string $ceilSalary): self
    {
        $this->ceilSalary = $ceilSalary;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
