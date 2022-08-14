<?php

namespace App\Dto\Notification;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Constant\Notification\ChannelConstant;
use App\Constant\Validator\Group;
use App\Validator\Group\NotificationGroupGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    attributes: [
        'validation_groups' => NotificationGroupGenerator::class
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
    collectionOperations: [
        'post' => [
            'validation_groups' => NotificationGroupGenerator::class
        ]
    ]
)]
class NotificationDto
{
    #[Groups(['read'])]
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    public ?int $clientId = null;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: ChannelConstant::VALUES)]
    #[ApiProperty(
        attributes: [
            'openapi_context' => [
                'enum' => ChannelConstant::VALUES,
                'example' => ChannelConstant::SMS
            ]
        ]
    )]
    #[Groups(['read', 'write'])]
    public ?string $channel = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 5000,
        groups: [Group::NOTIFICATION_ADD_EMAIL]
    )]
    #[Assert\Length(
        min: 1,
        max: 140,
        groups: [Group::NOTIFICATION_ADD_SMS]
    )]
    #[Groups(['read', 'write'])]
    public ?string $content = null;
}