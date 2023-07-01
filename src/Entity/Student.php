<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $fatherName = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dob = null;

  
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $birthPlace = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $currentAddress = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $houseNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $maritalStatus = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Woreda $woreda = null;

    #[ORM\Column(length: 50)]
    private ?string $kebele = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Country $nationality = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?User $user = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $idNumber = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Registration::class)]
    private Collection $registrations;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: StudentLeave::class)]
    private Collection $studentLeaves;

    #[ORM\OneToOne(inversedBy: 'student', cascade: ['persist', 'remove'])]
    private ?User $account = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: StudentParent::class)]
    private Collection $studentParents;

    #[ORM\Column(nullable: true)]
    private ?bool $isdropOut = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $firstNameAm = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $fatherNameAm = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $lastNameAm = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDisabled = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: StudentPayment::class)]
    private Collection $studentPayments;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $this->studentLeaves = new ArrayCollection();
        $this->studentParents = new ArrayCollection();
        $this->studentPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName();
    }
 

    public function getName()
    {
     return $this->firstName." ".$this->fatherName;
      
    }
    public function getFullName()
    {
       return $this->getName()." ".$this->lastName;
        
    }
    

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(string $fatherName): self
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getCurrentAddress(): ?string
    {
        return $this->currentAddress;
    }

    public function setCurrentAddress(?string $currentAddress): self
    {
        $this->currentAddress = $currentAddress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(?string $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getWoreda(): ?Woreda
    {
        return $this->woreda;
    }

    public function setWoreda(?Woreda $woreda): self
    {
        $this->woreda = $woreda;

        return $this;
    }

    public function getKebele(): ?string
    {
        return $this->kebele;
    }

    public function setKebele(string $kebele): self
    {
        $this->kebele = $kebele;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNationality(): ?Country
    {
        return $this->nationality;
    }

    public function setNationality(?Country $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    public function setIdNumber(?string $idNumber): self
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setStudent($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getStudent() === $this) {
                $registration->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentLeave>
     */
    public function getStudentLeaves(): Collection
    {
        return $this->studentLeaves;
    }

    public function addStudentLeaf(StudentLeave $studentLeaf): static
    {
        if (!$this->studentLeaves->contains($studentLeaf)) {
            $this->studentLeaves->add($studentLeaf);
            $studentLeaf->setStudent($this);
        }

        return $this;
    }

    public function removeStudentLeaf(StudentLeave $studentLeaf): static
    {
        if ($this->studentLeaves->removeElement($studentLeaf)) {
            // set the owning side to null (unless already changed)
            if ($studentLeaf->getStudent() === $this) {
                $studentLeaf->setStudent(null);
            }
        }

        return $this;
    }

    public function getAccount(): ?User
    {
        return $this->account;
    }

    public function setAccount(?User $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, StudentParent>
     */
    public function getStudentParents(): Collection
    {
        return $this->studentParents;
    }

    public function addStudentParent(StudentParent $studentParent): static
    {
        if (!$this->studentParents->contains($studentParent)) {
            $this->studentParents->add($studentParent);
            $studentParent->setStudent($this);
        }

        return $this;
    }

    public function removeStudentParent(StudentParent $studentParent): static
    {
        if ($this->studentParents->removeElement($studentParent)) {
            // set the owning side to null (unless already changed)
            if ($studentParent->getStudent() === $this) {
                $studentParent->setStudent(null);
            }
        }

        return $this;
    }

    public function isIsdropOut(): ?bool
    {
        return $this->isdropOut;
    }

    public function setIsdropOut(?bool $isdropOut): static
    {
        $this->isdropOut = $isdropOut;

        return $this;
    }

    public function getFirstNameAm(): ?string
    {
        return $this->firstNameAm;
    }

    public function setFirstNameAm(?string $firstNameAm): static
    {
        $this->firstNameAm = $firstNameAm;

        return $this;
    }

    public function getFatherNameAm(): ?string
    {
        return $this->fatherNameAm;
    }

    public function setFatherNameAm(?string $fatherNameAm): static
    {
        $this->fatherNameAm = $fatherNameAm;

        return $this;
    }

    public function getLastNameAm(): ?string
    {
        return $this->lastNameAm;
    }

    public function setLastNameAm(?string $lastNameAm): static
    {
        $this->lastNameAm = $lastNameAm;

        return $this;
    }

    public function isIsDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(?bool $isDisabled): static
    {
        $this->isDisabled = $isDisabled;

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
            $studentPayment->setStudent($this);
        }

        return $this;
    }

    public function removeStudentPayment(StudentPayment $studentPayment): static
    {
        if ($this->studentPayments->removeElement($studentPayment)) {
            // set the owning side to null (unless already changed)
            if ($studentPayment->getStudent() === $this) {
                $studentPayment->setStudent(null);
            }
        }

        return $this;
    }
}
