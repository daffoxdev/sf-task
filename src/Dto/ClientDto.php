<?php

namespace App\Dto;

use App\Constant\Validator\Group;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

class ClientDto implements DtoInterface
{
    #[Assert\NotBlank(groups: [Group::CLIENT_EDIT])]
    public ?int $id = null;

    #[Assert\Length(min: 2, max: 32)]
    public string $firstName;

    #[Assert\Length(min: 2, max: 32)]
    public string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[AssertPhoneNumber]
    public string $phoneNumber;
}