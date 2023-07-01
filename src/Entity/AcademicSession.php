<?php

namespace App\Entity;

use App\Repository\AcademicSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcademicSessionRepository::class)]
class AcademicSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end = null;

    #[ORM\ManyToOne(inversedBy: 'academicSessions')]
    private ?PaymentSession $paymentSession = null;

    #[ORM\OneToMany(mappedBy: 'accademicSession', targetEntity: StudentPayment::class)]
    private Collection $studentPayments;

    public function __construct()
    {
        $this->studentPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function __toString()
    {
        return $this->getYear();

        //return $this->year. '['.$this->getStart().' - '.$this->getEnd().']';

    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getPaymentSession(): ?PaymentSession
    {
        return $this->paymentSession;
    }

    public function setPaymentSession(?PaymentSession $paymentSession): static
    {
        $this->paymentSession = $paymentSession;

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
            $studentPayment->setAccademicSession($this);
        }

        return $this;
    }

    public function removeStudentPayment(StudentPayment $studentPayment): static
    {
        if ($this->studentPayments->removeElement($studentPayment)) {
            // set the owning side to null (unless already changed)
            if ($studentPayment->getAccademicSession() === $this) {
                $studentPayment->setAccademicSession(null);
            }
        }

        return $this;
    }
}
