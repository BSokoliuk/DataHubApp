<?php

namespace App\Entity;

use App\Repository\WorkExperienceRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WorkExperienceRepository::class)]
class WorkExperience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Company name is required')]
    #[Assert\Length(max: 255, maxMessage: 'Company name must be at most {{ limit }} characters')]
    private ?string $company = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Position is required')]
    #[Assert\Length(max: 255, maxMessage: 'Position must be at most {{ limit }} characters')]
    private ?string $position = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: 'From date is required')]
    #[Assert\GreaterThan('-100 years', message: 'From date must be at least 100 years ago')]
    #[Assert\LessThan(propertyPath: 'dateTo', message: 'From date must be before the To date')]
    private ?DateTimeImmutable $dateFrom = null;

    #[ORM\Column(type: 'date')]
    #[Assert\GreaterThan(propertyPath: 'dateFrom', message: 'To date must be after the From date')]
    #[Assert\LessThan('+0 years', message: 'To date must be in the past')]
    #[Assert\NotBlank(message: 'From date is required')]
    private ?DateTimeImmutable $dateTo = null;

    #[ORM\ManyToOne(inversedBy: 'workExperiences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PrimaryData $primaryData = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getDateFrom(): ?DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function setDateFrom(?DateTimeImmutable $dateFrom): static
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function setDateTo(?DateTimeImmutable $dateTo): static
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getPrimaryData(): ?PrimaryData
    {
        return $this->primaryData;
    }

    public function setPrimaryData(?PrimaryData $primaryData): static
    {
        $this->primaryData = $primaryData;

        return $this;
    }
}
