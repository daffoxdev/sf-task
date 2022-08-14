<?php

namespace App\Constant\Notification;

final class ChannelConstant
{
    public const SMS = 'sms';
    public const EMAIL = 'email';

    public const VALUES = [
        self::SMS,
        self::EMAIL,
    ];

    private function __construct()
    {
    }
}