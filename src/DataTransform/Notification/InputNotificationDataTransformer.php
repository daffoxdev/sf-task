<?php

namespace App\DataTransform\Notification;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\Notification\NotificationDto;
use App\Entity\Notification;
use App\Repository\ClientRepository;
use App\Validator\Group\NotificationGroupGenerator;
use LogicException;

class InputNotificationDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @param NotificationDto $object
     * @param string $to
     * @param array $context
     * @return Notification
     */
    public function transform($object, string $to, array $context = []): Notification
    {
        $this->validator->validate($object, [
            'groups' => NotificationGroupGenerator::class
        ]);

        $notification = new Notification();

        $notification->setContent($object->content);

        if (!$client = $this->clientRepository->find($object->clientId)) {
            throw new LogicException(sprintf(
                'Client #%s should be existed. Something wrong with validation level',
                $object->clientId
            ));
        }

        $notification->setClient($client);
        $notification->setChannel($object->channel);

        return $notification;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Notification) {
            return false;
        }

        $inputClass = ($context['input']['class'] ?? null);

        return
            Notification::class === $to
            && !is_null($inputClass);
    }
}