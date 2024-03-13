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
        'Cookies chocolat blanc pistaches' => [
            'individuel'
        ],
        'Cake marbré' => [
            '4 personnes', '8 personnes', '12 personnes'
        ],
        'Le cheesecake' => [
            '8 personnes', '12 personnes'
        ],
        'Noisette gourmande' => [
            'individuel'
        ],
        'Chausson aux pommes' => [
            'individuel'
        ],
        'Noisettes et amandes au chocolat' => [
            'individuel','4 personnes', '6 personnes', '8 personnes'
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
