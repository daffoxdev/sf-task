<?php

namespace App\Constant\Validator;

final class Group
{
    public const DEFAULT = 'Default';
    public const CLIENT_ADD = 'client_add';
    public const CLIENT_EDIT = 'client_edit';

    public const NOTIFICATION_ADD_SMS = 'notification:add:sms';
    public const NOTIFICATION_ADD_EMAIL = 'notification:add:email';

    private function __constrict(): void
    {
    }
}