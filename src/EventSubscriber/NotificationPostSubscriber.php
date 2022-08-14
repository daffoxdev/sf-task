<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Constant\Notification\ChannelConstant;
use App\Entity\Notification;
use App\Messenger\Message\EmailNotificationMessage;
use App\Messenger\Message\SmsNotificationMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationPostSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly LoggerInterface $logger
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['pushToMessageBus', EventPriorities::POST_WRITE],
        ];
    }

    public function pushToMessageBus(ViewEvent $event)
    {
        $notificationEntity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$notificationEntity instanceof Notification
            || Request::METHOD_POST !== $method
        ) {
            return;
        }

        $message = match ($notificationEntity->getChannel()) {
            ChannelConstant::SMS => new SmsNotificationMessage($notificationEntity->getId()),
            ChannelConstant::EMAIL => new EmailNotificationMessage($notificationEntity->getId()),
            default => null,
        };

        if (!$message) {
            $this->logger->error(
                'Not defined messenger message object for channel "{channel}"', [
                    'channel' => $notificationEntity->getChannel()
            ]);

            return;
        }

        $this->messageBus->dispatch($message);
    }
}