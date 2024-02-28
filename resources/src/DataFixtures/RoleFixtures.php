<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = [
            ['name' => 'Administrateur', 'code' => 'admin'],
            ['name' => 'Utilisateur', 'code' => 'client'],
        ];

        foreach ($roles as $roleDetails) {
            $role = (new Role())
                ->setName($roleDetails['name'])
                ->setCode($roleDetails['code']);
            $manager->persist($role);
            $this->addReference($roleDetails['code'], $role);
        }

        $manager->flush();
    }
}
