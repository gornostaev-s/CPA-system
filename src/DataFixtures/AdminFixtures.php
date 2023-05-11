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
                'name' => 'Админ',
                'phone' => '70000000000',
                'email' => 'admin@birzha-leads.com',
                'role' => 'ROLE_ADMIN',
                'password' => 'password'
            ]
        ];

        foreach ($usersData as $user) {
            $newUser = User::make($user['phone'], $user['email'], $user['name'], $user['role']);
            $newUser->setPassword($this->encoder->hashPassword($newUser, $user['password']));
            $manager->persist($newUser);
        }

        $manager->flush();
    }
}