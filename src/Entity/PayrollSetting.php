<?php

namespace App\Entity;

use App\Repository\PayrollSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayrollSettingRepository::class)]
class PayrollSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $incomeStart = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $incomeTo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $incomeTax = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $deduction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $pension = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIncomeStart(): ?string
    {
        return $this->incomeStart;
    }

    public function setIncomeStart(string $incomeStart): self
    {
        $this->incomeStart = $incomeStart;

        return $this;
    }

    public function getIncomeTo(): ?string
    {
        return $this->incomeTo;
    }

    public function setIncomeTo(string $incomeTo): self
    {
        $this->incomeTo = $incomeTo;

        return $this;
    }

    public function getIncomeTax(): ?string
    {
        return $this->incomeTax;
    }

    public function setIncomeTax(string $incomeTax): self
    {
        $this->incomeTax = $incomeTax;

        return $this;
    }

    public function getDeduction(): ?string
    {
        return $this->deduction;
    }

    public function setDeduction(string $deduction): self
    {
        $this->deduction = $deduction;

        return $this;
    }

    public function getPension(): ?string
    {
        return $this->pension;
    }

    public function setPension(string $pension): self
    {
        $this->pension = $pension;

        return $this;
    }
}
