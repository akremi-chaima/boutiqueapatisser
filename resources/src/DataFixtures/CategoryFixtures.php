<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'vinneoiserie',
            'gateau',
            'biscuit',
            'chocolat et bonbons'
        ];

        foreach ($categories as $categoryName) {
            $category = (new Category())
                ->setName($categoryName)
                ->setIsActive(true);
            $manager->persist($category);
            $this->addReference($categoryName, $category);
        }

        $manager->flush();
    }
}
