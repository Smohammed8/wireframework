<?php

namespace App\Entity;

use App\Repository\TeacherEducationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherEducationRepository::class)]
class TeacherEducation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teacherEducation')]
    private ?User $teacher = null;

    #[ORM\ManyToOne(inversedBy: 'teacherEducation')]
    private ?Education $education = null;

    #[ORM\ManyToOne(inversedBy: 'teacherEducation')]
    private ?FieldOfStudy $fieldOfStudy = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $major = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getEducation(): ?Education
    {
        return $this->education;
    }

    public function setEducation(?Education $education): static
    {
        $this->education = $education;

        return $this;
    }

    public function getFieldOfStudy(): ?FieldOfStudy
    {
        return $this->fieldOfStudy;
    }

    public function setFieldOfStudy(?FieldOfStudy $fieldOfStudy): static
    {
        $this->fieldOfStudy = $fieldOfStudy;

        return $this;
    }

    public function getMajor(): ?string
    {
        return $this->major;
    }

    public function setMajor(?string $major): static
    {
        $this->major = $major;

        return $this;
    }
}
