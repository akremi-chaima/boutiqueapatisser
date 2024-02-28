<?php

namespace App\DataFixtures;

use App\Entity\Pastry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PastryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $pastries = [
        ['name' => 'cookie pistachio', 'price' => 12, 'description' => 'un bon cookie traditionnel au pistache', 'isVisible' => true, 'category' => 'biscuit', 'subCollection' => 'Pistache pistache', 'flavour' => 'pistache'],
        ['name' => 'cake marbré', 'price' => 20, 'description' => 'Mi chocolat – mi nature, en toute simplicité, confectionné avec de bons ingrédients', 'isVisible' => true, 'category' => 'gateau', 'subCollection' => 'Gateaux de voyage', 'flavour' => 'chocolat'],
        ['name' => 'noisette gourmande', 'price' => 7.50, 'description' => 'Noisette Gourmande dans une nouvelle version tellement réconfortante avec son coeur praliné ultra fondant aussi régressif qu’addictif', 'isVisible' => true, 'category' => 'gateau', 'subCollection' => 'Les intemporelle', 'flavour' => 'noisette'],
    ];

        foreach ($pastries as $pastryDetails) {
            $pastry = (new Pastry())
                ->setName($pastryDetails['name'])
                ->setPrice($pastryDetails['price'])
                ->setDescription($pastryDetails['description'])
                ->setIsVisible($pastryDetails['isVisible'])
                ->setPicture(null)
                ->setCategory($this->getReference($pastryDetails['category']))
                ->setSubCollection($this->getReference($pastryDetails['subCollection']))
                ->setFlavour($this->getReference($pastryDetails['flavour']));
            $manager->persist($pastry);
            $this->addReference($pastryDetails['name'], $pastry);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            SubCollectionFixtures::class,
            FlavourFixtures::class,
        ];
    }
}
