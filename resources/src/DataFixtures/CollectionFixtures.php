<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $collections = [
        'Collection saisonnière',
        'Collection permanente',
    ];

        foreach ($collections as $collectionName) {
            $collection = (new Collection())
                ->setName($collectionName)
                ->setIsActive(true);
            $manager->persist($collection);
            $this->addReference($collectionName, $collection);
        }

        $manager->flush();
    }
}
