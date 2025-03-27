<?php

namespace App\Entity;

use App\Repository\PrimaryDataRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PrimaryDataRepository::class)]
class PrimaryData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'First name is required')]
    #[Assert\Length(max: 50, maxMessage: 'First name must be at most {{ limit }} characters')]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Last name is required')]
    #[Assert\Length(max: 50, maxMessage: 'Last name must be at most {{ limit }} characters')]
    private ?string $lastName = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: 'Birth date is required')]
    #[Assert\GreaterThan('-100 years', message: 'Birth date must be at least 100 years ago')]
    #[Assert\LessThan('+0 years', message: 'Birth date must be in the past')]
    private ?DateTimeImmutable $birthDate = null;

    #[ORM\OneToOne(targetEntity: ContactDetails::class, mappedBy: 'primaryData', cascade: ['persist', 'remove'])]
    private ?ContactDetails $contactDetails = null;

    /**
     * @var Collection<int, WorkExperience>
     */
    #[ORM\OneToMany(targetEntity: WorkExperience::class, mappedBy: 'primaryData', orphanRemoval: true)]
    private Collection $workExperiences;

    public function __construct()
    {
        $this->workExperiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getContactDetails(): ?ContactDetails
    {
        return $this->contactDetails;
    }

    public function setContactDetails(ContactDetails $contactDetails): static
    {
        $this->contactDetails = $contactDetails;

        return $this;
    }

    /**
     * @return Collection<int, WorkExperience>
     */
    public function getWorkExperiences(): Collection
    {
        return $this->workExperiences;
    }

    public function addWorkExperience(WorkExperience $workExperience): static
    {
        if (!$this->workExperiences->contains($workExperience)) {
            $this->workExperiences->add($workExperience);
            $workExperience->setPrimaryData($this);
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): static
    {
        if ($this->workExperiences->removeElement($workExperience)) {
            // set the owning side to null (unless already changed)
            if ($workExperience->getPrimaryData() === $this) {
                $workExperience->setPrimaryData(null);
            }
        }

        return $this;
    }
}
