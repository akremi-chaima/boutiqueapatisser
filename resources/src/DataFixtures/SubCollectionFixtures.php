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
        'Collection saisonnière' => [
            'Créations de saison'

        ],
        'Collection permanente' => [
            'Les intemporelles', 'Gateaux de voyage', 'Collection gourmandises', 'Chocolat et Bonbons'

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
