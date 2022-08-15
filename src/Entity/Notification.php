<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Constant\User\RoleConstant;
use App\Dto\Notification\NotificationDto;
use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get'],
    attributes: [
        "security" => "is_granted('" . RoleConstant::PRIVATE_API . "')",
        'pagination_items_per_page' => 5,
    ],
    input: NotificationDto::class,
    output: NotificationDto::class
)]
#[ApiFilter(SearchFilter::class, properties: [
    'client.id' => 'exact'
])]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'notifications')]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private Client $client;

    #[ORM\Column(type: 'string', length: 32)]
    private string $channel;

    #[ORM\Column(type: 'text', length: 5000)]
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