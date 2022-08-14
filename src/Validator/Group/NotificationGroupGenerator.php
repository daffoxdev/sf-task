<?php

namespace App\Validator\Group;

use ApiPlatform\Core\Bridge\Symfony\Validator\ValidationGroupsGeneratorInterface;
use App\Constant\Notification\ChannelConstant;
use App\Constant\Validator\Group;
use App\Dto\Notification\NotificationDto;
use LogicException;

class NotificationGroupGenerator implements ValidationGroupsGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($object): array
    {
        assert($object instanceof NotificationDto);

        $groups = [Group::DEFAULT];

        if (!$object->channel || !is_string($object->channel)) {
            return $groups;
        }

        $groupToAdd = match ($object->channel) {
            ChannelConstant::SMS => Group::NOTIFICATION_ADD_SMS,
            ChannelConstant::EMAIL => Group::NOTIFICATION_ADD_EMAIL,
            default => null
        };

        if ($groupToAdd) {
            $groups[] = $groupToAdd;
        }

        return $groups;
    }
}