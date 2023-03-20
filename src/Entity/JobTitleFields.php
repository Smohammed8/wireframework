<?php

namespace App\Entity;

use App\Repository\JobTitleFieldsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobTitleFieldsRepository::class)]
class JobTitleFields
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobTitleFields')]
    private ?JobTitle $jobTitle = null;

    #[ORM\ManyToOne(inversedBy: 'jobTitleFields')]
    private ?FieldOfStudy $fieldOfStudy = null;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?JobTitle
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?JobTitle $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

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

   
}
