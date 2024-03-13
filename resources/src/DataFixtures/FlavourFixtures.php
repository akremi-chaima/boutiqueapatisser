<?php

namespace App\DataFixtures;

use App\Entity\Flavour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FlavourFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $flavours = [
        'Fraise',
        'Noisette',
        'Pistache',
        'Chocolat',
        'Pommes',
        'Citron'
    ];

        foreach ($flavours as $flavourName) {
            $flavour = (new Flavour())
                ->setName($flavourName)
                ->setIsActive(true);
            $manager->persist($flavour);
            $this->addReference($flavourName, $flavour);
        }

        $manager->flush();
    }
}
