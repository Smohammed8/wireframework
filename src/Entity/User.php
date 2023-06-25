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

    #[ORM\Column(type: 'json')]
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



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

  

    #[ORM\ManyToMany(targetEntity: UserGroup::class, inversedBy: 'users')]
    private Collection $userGroup;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Student::class)]
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Registration::class)]
    private Collection $registrations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StudentUpload::class)]
    private Collection $studentUploads;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StudentLeave::class)]
    private Collection $studentLeaves;

    #[ORM\OneToOne(mappedBy: 'account', cascade: ['persist', 'remove'])]
    private ?Student $student = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StudentParent::class)]
    private Collection $studentParents;

    #[ORM\OneToMany(mappedBy: 'head', targetEntity: SectionHead::class)]
    private Collection $sectionHeads;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: SubjectAssignment::class)]
    private Collection $subjectAssignments;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: TeacherEducation::class)]
    private Collection $teacherEducation;
    public function __construct()
    {
        $this->userGroup = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->registrations = new ArrayCollection();
        $this->studentUploads = new ArrayCollection();
        $this->studentLeaves = new ArrayCollection();
        $this->studentParents = new ArrayCollection();
        $this->sectionHeads = new ArrayCollection();
        $this->subjectAssignments = new ArrayCollection();
        $this->teacherEducation = new ArrayCollection();
    
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
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */

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
     * @return Collection<int, UserGroup>
     */
    public function getUserGroup(): Collection
    {
        return $this->userGroup;
    }

    public function addUserGroup(UserGroup $userGroup): self
    {
        if (!$this->userGroup->contains($userGroup)) {
            $this->userGroup->add($userGroup);
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): self
    {
        $this->userGroup->removeElement($userGroup);

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setUser($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getUser() === $this) {
                $student->setUser(null);
            }
        }

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
            $registration->setUser($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getUser() === $this) {
                $registration->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentUpload>
     */
    public function getStudentUploads(): Collection
    {
        return $this->studentUploads;
    }

    public function addStudentUpload(StudentUpload $studentUpload): static
    {
        if (!$this->studentUploads->contains($studentUpload)) {
            $this->studentUploads->add($studentUpload);
            $studentUpload->setUser($this);
        }

        return $this;
    }

    public function removeStudentUpload(StudentUpload $studentUpload): static
    {
        if ($this->studentUploads->removeElement($studentUpload)) {
            // set the owning side to null (unless already changed)
            if ($studentUpload->getUser() === $this) {
                $studentUpload->setUser(null);
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
            $studentLeaf->setUser($this);
        }

        return $this;
    }

    public function removeStudentLeaf(StudentLeave $studentLeaf): static
    {
        if ($this->studentLeaves->removeElement($studentLeaf)) {
            // set the owning side to null (unless already changed)
            if ($studentLeaf->getUser() === $this) {
                $studentLeaf->setUser(null);
            }
        }

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        // unset the owning side of the relation if necessary
        if ($student === null && $this->student !== null) {
            $this->student->setAccount(null);
        }

        // set the owning side of the relation if necessary
        if ($student !== null && $student->getAccount() !== $this) {
            $student->setAccount($this);
        }

        $this->student = $student;

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
            $studentParent->setUser($this);
        }

        return $this;
    }

    public function removeStudentParent(StudentParent $studentParent): static
    {
        if ($this->studentParents->removeElement($studentParent)) {
            // set the owning side to null (unless already changed)
            if ($studentParent->getUser() === $this) {
                $studentParent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SectionHead>
     */
    public function getSectionHeads(): Collection
    {
        return $this->sectionHeads;
    }

    public function addSectionHead(SectionHead $sectionHead): static
    {
        if (!$this->sectionHeads->contains($sectionHead)) {
            $this->sectionHeads->add($sectionHead);
            $sectionHead->setHead($this);
        }

        return $this;
    }

    public function removeSectionHead(SectionHead $sectionHead): static
    {
        if ($this->sectionHeads->removeElement($sectionHead)) {
            // set the owning side to null (unless already changed)
            if ($sectionHead->getHead() === $this) {
                $sectionHead->setHead(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubjectAssignment>
     */
    public function getSubjectAssignments(): Collection
    {
        return $this->subjectAssignments;
    }

    public function addSubjectAssignment(SubjectAssignment $subjectAssignment): static
    {
        if (!$this->subjectAssignments->contains($subjectAssignment)) {
            $this->subjectAssignments->add($subjectAssignment);
            $subjectAssignment->setTeacher($this);
        }

        return $this;
    }

    public function removeSubjectAssignment(SubjectAssignment $subjectAssignment): static
    {
        if ($this->subjectAssignments->removeElement($subjectAssignment)) {
            // set the owning side to null (unless already changed)
            if ($subjectAssignment->getTeacher() === $this) {
                $subjectAssignment->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeacherEducation>
     */
    public function getTeacherEducation(): Collection
    {
        return $this->teacherEducation;
    }

    public function addTeacherEducation(TeacherEducation $teacherEducation): static
    {
        if (!$this->teacherEducation->contains($teacherEducation)) {
            $this->teacherEducation->add($teacherEducation);
            $teacherEducation->setTeacher($this);
        }

        return $this;
    }

    public function removeTeacherEducation(TeacherEducation $teacherEducation): static
    {
        if ($this->teacherEducation->removeElement($teacherEducation)) {
            // set the owning side to null (unless already changed)
            if ($teacherEducation->getTeacher() === $this) {
                $teacherEducation->setTeacher(null);
            }
        }

        return $this;
    }

     
    
}
