<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Constant\User\RoleConstant;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => ["security" => "is_granted('" . RoleConstant::PRIVATE_API . "')"],
        "post"
    ],
    itemOperations: [
        "get",
        "put",
        'delete'
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
)]
#[UniqueEntity('email')]
#[UniqueEntity('phoneNumber')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 32)]
    #[Assert\Length(min: 2, max: 32)]
    #[Groups(['read', 'write'])]
    private string $firstName;

    #[ORM\Column(length: 32)]
    #[Assert\Length(min: 2, max: 32)]
    #[Groups(['read', 'write'])]
    private string $lastName;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['read', 'write'])]
    private string $email;

    #[ORM\Column(length: 35, unique: true)]
    #[Assert\NotBlank]
    #[AssertPhoneNumber]
    #[Groups(['read', 'write'])]
    private string $phoneNumber;

    #[ORM\OneToMany(
        mappedBy: 'client',
        targetEntity: Notification::class,
        cascade: ['remove'])
    ]
    public iterable $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}