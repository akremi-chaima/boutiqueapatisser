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
        [
            'name' => 'Cookies choco pistaches',
            'price' => 2.9,
            'description' => 'Deux saveurs pour ce grand classique apprécié à toute heure par les petits comme les grands gourmands ! Découvrez notre nouvelle version qui associe chocolat blanc et pistaches.',
            'isVisible' => true,
            'category' => 'Biscuit',
            'subCollection' => 'Gateaux de voyage',
            'flavour' => 'Pistache'
        ],
        [
            'name' => 'Cake marbré',
            'price' => 20,
            'description' => 'Mi chocolat – mi nature, en toute simplicité, confectionné avec de bons ingrédients, ce marbré très fondant est le gâteau à partager qui réunit les petits et les grands à l’heure du goûter.',
            'isVisible' => true,
            'category' => 'Patisserie',
            'subCollection' => 'Gateaux de voyage',
            'flavour' => 'Chocolat'
        ],
        [
            'name' => 'Le cheesecake',
            'price' => 32,
            'description' => 'Un cheesecake à fondre de plaisir ! Tous les goûts du gâteau traditionnel magnifiés par de beaux produits français sélectionnés avec amour ! La saveur légèrement épicée d’un sablé croustillant. Et un jeu de texture avec la fraîcheur aérienne d’une mousse au fromage frais parfumée aux zestes de citron qui renferme un coeur fondant.',
            'isVisible' => true,
            'category' => 'Patisserie',
            'subCollection' => 'Les intemporelles',
            'flavour' => 'Noisette'
        ],
        [
            'name' => 'Noisette gourmande',
            'price' => 7.5,
            'description' => 'Retrouver les marqueurs de notre Noisette Gourmande dans une nouvelle version tellement réconfortante avec son coeur praliné ultra fondant aussi régressif qu’addictif !',
            'isVisible' => true,
            'category' => 'Entremets',
            'subCollection' => 'Créations de saison',
            'flavour' => 'Noisette'
        ],
        [
            'name' => 'Chausson aux pommes',
            'price' => 2.6,
            'description' => 'Une délicieuse pâtisserie composée d\'une fine couche de pâte feuilletée, enveloppant généreusement une garniture de compote de pommes sucrée et parfumée à la cannelle, saupoudré de sucre glace pour une touche de douceur supplémentaire.',
            'isVisible' => true,
            'category' => 'Viennoiserie',
            'subCollection' => 'Collection gourmandises',
            'flavour' => 'Pommes'
        ],
        [
            'name' => 'Noisettes au chocolat',
            'price' => 9.5,
            'description' => 'Assortiment chocolaté très gourmand à croquer sans modération entre noisettes et amandes enrobées de chocolat végétal aux saveurs intense, lactée ou caramel selon les bonbons',
            'isVisible' => true,
            'category' => 'Chocolat et bonbons',
            'subCollection' => 'Chocolat et Bonbons',
            'flavour' => 'Chocolat'
        ],
        [
            'name' => 'Tarte citron meringuée',
            'price' => 25,
            'description' => 'Citron yuzu pour le crémeux, zestes en fonction de l’arrivage : cette tarte invite à découvrir les saveurs subtiles d’agrumes d’exception. Un mariage délicat entre la puissance du fruit et la douceur de la meringue',
            'isVisible' => true,
            'category' => 'Entremets',
            'subCollection' => 'Les intemporelles',
            'flavour' => 'Citron'
        ],
        [
            'name' => 'Boîtes de chocolats',
            'price' => 22,
            'description' => 'Dans leur joli écrin à offrir comme pour se faire plaisir, découvrez les six saveurs de nos douceurs enrobées de chocolat noir ou de chocolat au lait entre ganaches, pralinés et coeur coulant caramel.',
            'isVisible' => true,
            'category' => 'Chocolat et bonbons',
            'subCollection' => 'Chocolat et Bonbons',
            'flavour' => 'Chocolat'
        ],
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
