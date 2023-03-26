<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;



#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $fatherName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column(length: 100)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SalaryScale::class)]
    private Collection $salaryScales;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EmployeeEducation::class)]
    private Collection $employeeEducation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: InternalExperience::class)]
    private Collection $internalExperiences;

    public function __construct()
    {
        $this->salaryScales = new ArrayCollection();
        $this->employeeEducation = new ArrayCollection();
        $this->internalExperiences = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, SalaryScale>
     */
    public function getSalaryScales(): Collection
    {
        return $this->salaryScales;
    }

    public function addSalaryScale(SalaryScale $salaryScale): self
    {
        if (!$this->salaryScales->contains($salaryScale)) {
            $this->salaryScales->add($salaryScale);
            $salaryScale->setUser($this);
        }

        return $this;
    }

    public function removeSalaryScale(SalaryScale $salaryScale): self
    {
        if ($this->salaryScales->removeElement($salaryScale)) {
            // set the owning side to null (unless already changed)
            if ($salaryScale->getUser() === $this) {
                $salaryScale->setUser(null);
            }
        }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeEducation>
     */
    public function getEmployeeEducation(): Collection
    {
        return $this->employeeEducation;
    }

    public function addEmployeeEducation(EmployeeEducation $employeeEducation): self
    {
        if (!$this->employeeEducation->contains($employeeEducation)) {
            $this->employeeEducation->add($employeeEducation);
            $employeeEducation->setUser($this);
        }

        return $this;
    }

    public function removeEmployeeEducation(EmployeeEducation $employeeEducation): self
    {
        if ($this->employeeEducation->removeElement($employeeEducation)) {
            // set the owning side to null (unless already changed)
            if ($employeeEducation->getUser() === $this) {
                $employeeEducation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InternalExperience>
     */
    public function getInternalExperiences(): Collection
    {
        return $this->internalExperiences;
    }

    public function addInternalExperience(InternalExperience $internalExperience): self
    {
        if (!$this->internalExperiences->contains($internalExperience)) {
            $this->internalExperiences->add($internalExperience);
            $internalExperience->setUser($this);
        }

        return $this;
    }

    public function removeInternalExperience(InternalExperience $internalExperience): self
    {
        if ($this->internalExperiences->removeElement($internalExperience)) {
            // set the owning side to null (unless already changed)
            if ($internalExperience->getUser() === $this) {
                $internalExperience->setUser(null);
            }
        }

        return $this;
    }
}
