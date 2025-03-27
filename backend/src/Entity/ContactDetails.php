<?php

namespace App\Entity;

use App\Repository\ContactDetailsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactDetailsRepository::class)]
class ContactDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'Phone number is required')]
    #[Assert\Regex(
        pattern: '/^\+\d{2} \d{3} \d{3} \d{3}$/',
        message: 'Phone number must contain only numbers and be in format +00 000 000 000'
    )]
    #[Assert\Length(max: 15, maxMessage: 'Email address must be at most {{ limit }} characters')]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email address is required')]
    #[Assert\Email(message: 'Invalid email address')]
    #[Assert\Length(max: 255, maxMessage: 'Email address must be at most {{ limit }} characters')]
    private ?string $emailAddress = null;

    #[ORM\OneToOne(inversedBy: 'contactDetails', targetEntity: PrimaryData::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?PrimaryData $primaryData = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): static
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPrimaryData(): ?PrimaryData
    {
        return $this->primaryData;
    }

    public function setPrimaryData(PrimaryData $primaryData): static
    {
        $this->primaryData = $primaryData;

        return $this;
    }
}
