<?php

namespace App\Service\Client;

use App\Dto\ClientDto;
use App\Entity\Client;

class ClientFactory
{
    public function createFromDto(ClientDto $clientDto): Client
    {
        $client = new Client();

        $client
            ->setFirstName($clientDto->firstName)
            ->setLastName($clientDto->lastName)
            ->setEmail($clientDto->email)
            ->setPhoneNumber($clientDto->phoneNumber);

        return $client;
    }
}