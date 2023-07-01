<?php

namespace App\Entity;

use App\Repository\MonthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonthRepository::class)]
class Month
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'month', targetEntity: StudentPayment::class)]
    private Collection $studentPayments;

    public function __construct()
    {
        $this->studentPayments = new ArrayCollection();
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, StudentPayment>
     */
    public function getStudentPayments(): Collection
    {
        return $this->studentPayments;
    }

    public function addStudentPayment(StudentPayment $studentPayment): static
    {
        if (!$this->studentPayments->contains($studentPayment)) {
            $this->studentPayments->add($studentPayment);
            $studentPayment->setMonth($this);
        }

        return $this;
    }

    public function removeStudentPayment(StudentPayment $studentPayment): static
    {
        if ($this->studentPayments->removeElement($studentPayment)) {
            // set the owning side to null (unless already changed)
            if ($studentPayment->getMonth() === $this) {
                $studentPayment->setMonth(null);
            }
        }

        return $this;
    }
}
