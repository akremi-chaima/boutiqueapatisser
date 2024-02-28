<?php

namespace App\DataFixtures;

use App\Entity\Format;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FormatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $formats = [
        'cookie pistachio' => [
            'individuel'
        ],
        'cake marbré' => [
            '4 personnes', '8 personnes', '12 personnes'
        ],
        'noisette gourmande' => [
            'individuel', '4 personnes'

        ],
    ];

        foreach ($formats as $pastryName => $formatsName) {
            foreach ($formatsName as $formatName) {
                $format = (new Format())
                    ->setName($formatName)
                    ->setPastry($this->getReference($pastryName));
                $manager->persist($format);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PastryFixtures::class,
        ];
    }
}
