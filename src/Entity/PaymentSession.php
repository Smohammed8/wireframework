<?php

namespace App\Entity;

use App\Repository\PaymentSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentSessionRepository::class)]
class PaymentSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'paymentSession', targetEntity: AcademicSession::class)]
    private Collection $academicSessions;

    public function __construct()
    {
        $this->academicSessions = new ArrayCollection();
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

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, AcademicSession>
     */
    public function getAcademicSessions(): Collection
    {
        return $this->academicSessions;
    }

    public function addAcademicSession(AcademicSession $academicSession): static
    {
        if (!$this->academicSessions->contains($academicSession)) {
            $this->academicSessions->add($academicSession);
            $academicSession->setPaymentSession($this);
        }

        return $this;
    }

    public function removeAcademicSession(AcademicSession $academicSession): static
    {
        if ($this->academicSessions->removeElement($academicSession)) {
            // set the owning side to null (unless already changed)
            if ($academicSession->getPaymentSession() === $this) {
                $academicSession->setPaymentSession(null);
            }
        }

        return $this;
    }
}
