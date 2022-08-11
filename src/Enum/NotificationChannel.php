<?php

namespace App\Enum;

enum NotificationChannel: string
{
    case CHANNEL_SMS = 'sms';
    case CHANNEL_EMAIL = 'email';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}