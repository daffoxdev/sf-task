<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class ClientIdConstraint extends Constraint
{
    public string $message = 'The client with id #{{ client_id }} not exist.';
    public string $code = '052e560f-7898-4046-a37a-b5b63dc3e5c9';

    public const NOT_FOUND_ERROR = '60d2f30b-8cfa-4372-b155-9656634de120';

    protected const ERROR_NAMES = [
        self::NOT_FOUND_ERROR => 'NOT_FOUND_ERROR',
    ];
}