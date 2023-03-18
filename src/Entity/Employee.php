<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
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

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $birthPlace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $bloodGroup = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $eyeColor = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $idNumber = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $pentionNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $firstNameAm = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $fatherNameAm = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $lastNameAm = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: EmergencyContact::class)]
    private Collection $emergencyContacts;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: EmployeeLanguage::class)]
    private Collection $employeeLanguages;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: ContractRange::class)]
    private Collection $contractRanges;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: ExternalExperience::class)]
    private Collection $externalExperiences;

    #[ORM\OneToMany(mappedBy: 'leader', targetEntity: Unit::class)]
    private Collection $units;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?EmployeeTitle $employeeTitle = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?EducationalLevel $educationallevel = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?MaritalStatus $martitalStatus = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Ethnicity $ethnicity = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Religion $religion = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?FieldOfStudy $fieldOfStudy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $employementDate = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?EmploymentType $employmentType = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?EmploymentStatus $employeeCurrentStatus = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Country $nationality = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?EmployeeCategory $employeeCategory = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Position $position = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $institution = null;

    public function __construct()
    {
        $this->emergencyContacts = new ArrayCollection();
        $this->employeeLanguages = new ArrayCollection();
        $this->contractRanges = new ArrayCollection();
        $this->externalExperiences = new ArrayCollection();
        $this->units = new ArrayCollection();
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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

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

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

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

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(?string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getEyeColor(): ?string
    {
        return $this->eyeColor;
    }

    public function setEyeColor(?string $eyeColor): self
    {
        $this->eyeColor = $eyeColor;

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

    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    public function setIdNumber(?string $idNumber): self
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    public function getPentionNumber(): ?string
    {
        return $this->pentionNumber;
    }

    public function setPentionNumber(?string $pentionNumber): self
    {
        $this->pentionNumber = $pentionNumber;

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

    public function getFirstNameAm(): ?string
    {
        return $this->firstNameAm;
    }

    public function setFirstNameAm(?string $firstNameAm): self
    {
        $this->firstNameAm = $firstNameAm;

        return $this;
    }

    public function getFatherNameAm(): ?string
    {
        return $this->fatherNameAm;
    }

    public function setFatherNameAm(?string $fatherNameAm): self
    {
        $this->fatherNameAm = $fatherNameAm;

        return $this;
    }

    public function getLastNameAm(): ?string
    {
        return $this->lastNameAm;
    }

    public function setLastNameAm(?string $lastNameAm): self
    {
        $this->lastNameAm = $lastNameAm;

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

    /**
     * @return Collection<int, EmergencyContact>
     */
    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContact $emergencyContact): self
    {
        if (!$this->emergencyContacts->contains($emergencyContact)) {
            $this->emergencyContacts->add($emergencyContact);
            $emergencyContact->setEmployee($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContact $emergencyContact): self
    {
        if ($this->emergencyContacts->removeElement($emergencyContact)) {
            // set the owning side to null (unless already changed)
            if ($emergencyContact->getEmployee() === $this) {
                $emergencyContact->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeLanguage>
     */
    public function getEmployeeLanguages(): Collection
    {
        return $this->employeeLanguages;
    }

    public function addEmployeeLanguage(EmployeeLanguage $employeeLanguage): self
    {
        if (!$this->employeeLanguages->contains($employeeLanguage)) {
            $this->employeeLanguages->add($employeeLanguage);
            $employeeLanguage->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeLanguage(EmployeeLanguage $employeeLanguage): self
    {
        if ($this->employeeLanguages->removeElement($employeeLanguage)) {
            // set the owning side to null (unless already changed)
            if ($employeeLanguage->getEmployee() === $this) {
                $employeeLanguage->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContractRange>
     */
    public function getContractRanges(): Collection
    {
        return $this->contractRanges;
    }

    public function addContractRange(ContractRange $contractRange): self
    {
        if (!$this->contractRanges->contains($contractRange)) {
            $this->contractRanges->add($contractRange);
            $contractRange->setEmployee($this);
        }

        return $this;
    }

    public function removeContractRange(ContractRange $contractRange): self
    {
        if ($this->contractRanges->removeElement($contractRange)) {
            // set the owning side to null (unless already changed)
            if ($contractRange->getEmployee() === $this) {
                $contractRange->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExternalExperience>
     */
    public function getExternalExperiences(): Collection
    {
        return $this->externalExperiences;
    }

    public function addExternalExperience(ExternalExperience $externalExperience): self
    {
        if (!$this->externalExperiences->contains($externalExperience)) {
            $this->externalExperiences->add($externalExperience);
            $externalExperience->setEmployee($this);
        }

        return $this;
    }

    public function removeExternalExperience(ExternalExperience $externalExperience): self
    {
        if ($this->externalExperiences->removeElement($externalExperience)) {
            // set the owning side to null (unless already changed)
            if ($externalExperience->getEmployee() === $this) {
                $externalExperience->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Unit>
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->units->contains($unit)) {
            $this->units->add($unit);
            $unit->setLeader($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->units->removeElement($unit)) {
            // set the owning side to null (unless already changed)
            if ($unit->getLeader() === $this) {
                $unit->setLeader(null);
            }
        }

        return $this;
    }

    public function getEmployeeTitle(): ?EmployeeTitle
    {
        return $this->employeeTitle;
    }

    public function setEmployeeTitle(?EmployeeTitle $employeeTitle): self
    {
        $this->employeeTitle = $employeeTitle;

        return $this;
    }

    public function getEducationallevel(): ?EducationalLevel
    {
        return $this->educationallevel;
    }

    public function setEducationallevel(?EducationalLevel $educationallevel): self
    {
        $this->educationallevel = $educationallevel;

        return $this;
    }

    public function getMartitalStatus(): ?MaritalStatus
    {
        return $this->martitalStatus;
    }

    public function setMartitalStatus(?MaritalStatus $martitalStatus): self
    {
        $this->martitalStatus = $martitalStatus;

        return $this;
    }

    public function getEthnicity(): ?Ethnicity
    {
        return $this->ethnicity;
    }

    public function setEthnicity(?Ethnicity $ethnicity): self
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function getReligion(): ?Religion
    {
        return $this->religion;
    }

    public function setReligion(?Religion $religion): self
    {
        $this->religion = $religion;

        return $this;
    }

    public function getFieldOfStudy(): ?FieldOfStudy
    {
        return $this->fieldOfStudy;
    }

    public function setFieldOfStudy(?FieldOfStudy $fieldOfStudy): self
    {
        $this->fieldOfStudy = $fieldOfStudy;

        return $this;
    }

    public function getEmployementDate(): ?\DateTimeInterface
    {
        return $this->employementDate;
    }

    public function setEmployementDate(\DateTimeInterface $employementDate): self
    {
        $this->employementDate = $employementDate;

        return $this;
    }

    public function getEmploymentType(): ?EmploymentType
    {
        return $this->employmentType;
    }

    public function setEmploymentType(?EmploymentType $employmentType): self
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    public function getEmployeeCurrentStatus(): ?EmploymentStatus
    {
        return $this->employeeCurrentStatus;
    }

    public function setEmployeeCurrentStatus(?EmploymentStatus $employeeCurrentStatus): self
    {
        $this->employeeCurrentStatus = $employeeCurrentStatus;

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

    public function getEmployeeCategory(): ?EmployeeCategory
    {
        return $this->employeeCategory;
    }

    public function setEmployeeCategory(?EmployeeCategory $employeeCategory): self
    {
        $this->employeeCategory = $employeeCategory;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(?string $institution): self
    {
        $this->institution = $institution;

        return $this;
    }
}
