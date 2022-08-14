<?php

namespace App\DataTransform\Notification;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\Notification\NotificationDto;
use App\Entity\Notification;

class OutputNotificationDataTransformer implements DataTransformerInterface
{
    /**
     * @param Notification $object
     * @param string $to
     * @param array $context
     * @return NotificationDto
     */
    public function transform($object, string $to, array $context = []): NotificationDto
    {
        $dto = new NotificationDto();
        $dto->id = $object->getId();
        $dto->content = $object->getContent();
        $dto->channel = $object->getChannel();
        $dto->clientId = $object->getClient()->getId();

        return $dto;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return
            NotificationDto::class === $to
            && $data instanceof Notification;
    }
}