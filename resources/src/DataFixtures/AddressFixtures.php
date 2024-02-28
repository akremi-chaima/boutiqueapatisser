<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $addresses = [
        ['city' => 'marseille', 'zipCode' => '13002', 'street' => '26 rue chevallier Paul', 'user' => 'chayma.akermi1997@gmail.com'],
        ['city' => 'paris', 'zipCode' => '75004', 'street' => '30 rue Paul', 'user' => 'chaima.akremi.1997@gmail.com'],
    ];

        foreach ($addresses as $addressDetails) {
            $address = (new Address())
                ->setCity($addressDetails['city'])
                ->setZipCode($addressDetails['zipCode'])
                ->setStreet($addressDetails['street'])
                ->setUser($this->getReference($addressDetails['user']));
            $manager->persist($address);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
