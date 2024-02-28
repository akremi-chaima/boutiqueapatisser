<?php

namespace App\DataFixtures;

use App\Entity\SubCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubCollectionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $subCollections = [
        'collection saisonnière' => [
            'Pistache pistache' , 'La Fleur vanille'

        ],
        'collection permanente' => [
            'Le cheesecake', 'Tarte Citron Meringuée', 'Les intemporelle', 'Gateaux de voyage'

        ],
    ];

        foreach ($subCollections as $collectionName => $subCollectionsName) {
            foreach ($subCollectionsName as $subCollectionName) {
                $subCollection = (new SubCollection())
                    ->setName($subCollectionName)
                    ->setIsActive(true)
                    ->setCollection($this->getReference($collectionName));
                $manager->persist($subCollection);
                $this->addReference($subCollectionName, $subCollection);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CollectionFixtures::class,
        ];
    }
}
