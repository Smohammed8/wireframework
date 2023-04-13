<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'zones')]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Woreda::class)]
    private Collection $woredas;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->woredas = new ArrayCollection();
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Woreda>
     */
    public function getWoredas(): Collection
    {
        return $this->woredas;
    }

    public function addWoreda(Woreda $woreda): self
    {
        if (!$this->woredas->contains($woreda)) {
            $this->woredas->add($woreda);
            $woreda->setZone($this);
        }

        return $this;
    }

    public function removeWoreda(Woreda $woreda): self
    {
        if ($this->woredas->removeElement($woreda)) {
            // set the owning side to null (unless already changed)
            if ($woreda->getZone() === $this) {
                $woreda->setZone(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
