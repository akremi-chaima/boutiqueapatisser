<?php

namespace App\DataFixtures;

use App\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ordersStatus = [
        'en attente de validation',
        'en cours de préparation',
        'préparé'
    ];

        foreach ($ordersStatus as $orderStatusName) {
            $orderStatus = (new OrderStatus())
                ->setName($orderStatusName);
            $manager->persist($orderStatus);
            $this->addReference($orderStatusName, $orderStatus);
        }

        $manager->flush();
    }
}
