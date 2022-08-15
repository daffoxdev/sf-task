<?php

namespace App\Dto\Notification;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Constant\Notification\ChannelConstant;
use App\Constant\Validator\Group;
use App\Validator\Constraints as AssertCustom;
use App\Validator\Group\NotificationGroupGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'validation_groups' => NotificationGroupGenerator::class
        ]
    ],
    attributes: [
        'validation_groups' => NotificationGroupGenerator::class
    ],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']]
)]
class NotificationDto
{
    #[Groups(['read'])]
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[AssertCustom\ClientIdConstraint]
    #[Groups(['read', 'write'])]
    public ?Uuid $clientId = null;

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