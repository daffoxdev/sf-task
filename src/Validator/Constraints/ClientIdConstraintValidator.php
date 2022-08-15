<?php

namespace App\Validator\Constraints;

use App\Repository\ClientRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ClientIdConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ClientRepository $clientRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ClientIdConstraint) {
            throw new UnexpectedTypeException($constraint, ClientIdConstraint::class);
        }

        // other constraints (NotBlank, NotNull, etc.) should care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value)) {
            throw new UnexpectedValueException($value, 'int');
        }

        $client = $this->clientRepository->find($value);

        if (!$client) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ client_id }}', $value)
                ->setCode(ClientIdConstraint::NOT_FOUND_ERROR)
                ->addViolation();
        }
    }
}