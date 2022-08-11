<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation as AA;
use App\Enum\NotificationChannel;
use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ApiResource]
class Notification
{
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_EMAIL = 'email';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    #[Assert\NotBlank]
    private Client $client;

    #[ORM\Column(type: 'string', length: 32)]
    #[Assert\NotBlank]
    #[Assert\Choice(callback: [NotificationChannel::class, 'values'])]
//    #[AA\ApiProperty(
//        attributes: [
//            'openapi_context' => [
//                'example' => 'NotificationChannel::values()'
//            ]
//        ]
//    )]
    private string $channel;

    #[ORM\Column(type: 'text', length: 5000)]
    #[Assert\NotBlank]
    private string $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
}