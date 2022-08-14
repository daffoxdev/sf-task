<?php

namespace App\Messenger\Message;

class EmailNotificationMessage
{
    public function __construct(
        public readonly int $notificationId
    ) {
    }
}