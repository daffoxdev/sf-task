<?php

namespace App\Messenger\Handler;

use App\Messenger\Message\SmsNotificationMessage;
use App\Repository\NotificationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SmsMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(SmsNotificationMessage $message)
    {
        $notificationId = $message->notificationId;

        $notification = $this->notificationRepository->find($notificationId);

        if (!$notification) {
            $this->logger->warning(
                'Notification #{notification_id} not exist anymore. Can\'t prepare email.'
            );

            return;
        }

        // TODO push sms to any sms handling provider
    }
}