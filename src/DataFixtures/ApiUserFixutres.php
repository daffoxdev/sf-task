<?php

namespace App\DataFixtures;

use App\Entity\ApiUser;
use App\Repository\ApiUserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiUserFixutres extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly ApiUserRepository $apiUserRepository
    ) {
    }


    public function load(ObjectManager $manager)
    {
        $apiUser = $this->apiUserRepository->findOneBy(['username' => 'api']);

        if ($apiUser) {
            return;
        }

        $apiUser = new ApiUser();
        $apiUser->setUsername('api');

        $password = $this->hasher->hashPassword($apiUser, 'api');

        $apiUser->setPassword($password);

        $apiUser->setRoles([
            'PUBLIC_ACCESS',
            'ROLE_PRIVATE_API'
        ]);

        $manager->persist($apiUser);
        $manager->flush();
    }
}