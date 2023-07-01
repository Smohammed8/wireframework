<?php

namespace App\Entity;

use App\Repository\RelationshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationshipRepository::class)]
class Relationship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: StudentParent::class)]
    private Collection $studentParents;

    public function __construct()
    {
        $this->studentParents = new ArrayCollection();
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
            $studentParent->setRelation($this);
        }

        return $this;
    }

    public function removeStudentParent(StudentParent $studentParent): static
    {
        if ($this->studentParents->removeElement($studentParent)) {
            // set the owning side to null (unless already changed)
            if ($studentParent->getRelation() === $this) {
                $studentParent->setRelation(null);
            }
        }

        return $this;
    }
}
