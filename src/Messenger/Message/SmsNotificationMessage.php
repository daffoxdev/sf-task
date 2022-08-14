<?php

namespace App\Messenger\Message;

class SmsNotificationMessage
{
    public function __construct(
        public readonly int $notificationId
    ) {
    }
}