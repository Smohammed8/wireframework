<?php

namespace App\Entity;

use App\Repository\FieldOfStudyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldOfStudyRepository::class)]
class FieldOfStudy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'fieldOfStudy', targetEntity: TeacherEducation::class)]
    private Collection $teacherEducation;

    public function __construct()
    {
        $this->teacherEducation = new ArrayCollection();
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
            $teacherEducation->setFieldOfStudy($this);
        }

        return $this;
    }

    public function removeTeacherEducation(TeacherEducation $teacherEducation): static
    {
        if ($this->teacherEducation->removeElement($teacherEducation)) {
            // set the owning side to null (unless already changed)
            if ($teacherEducation->getFieldOfStudy() === $this) {
                $teacherEducation->setFieldOfStudy(null);
            }
        }

        return $this;
    }
}
