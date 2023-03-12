<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $encoder)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [
                'email' => 'admin@birzha-leads.com',
                'role' => ['admin'],
                'password' => 'password'
            ]
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->encoder->hashPassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}