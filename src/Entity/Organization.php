<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $moto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Employee $leader = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pobox = null;

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

    public function getMoto(): ?string
    {
        return $this->moto;
    }

    public function setMoto(?string $moto): self
    {
        $this->moto = $moto;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getPobox(): ?string
    {
        return $this->pobox;
    }

    public function setPobox(?string $pobox): self
    {
        $this->pobox = $pobox;

        return $this;
    }
}
