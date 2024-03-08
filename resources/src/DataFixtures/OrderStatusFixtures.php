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
            OrderStatus::WAITING_FOR_VALIDATION,
            OrderStatus::IN_PREPARATION,
            OrderStatus::AWAITING_DELIVERY,
            OrderStatus::PAID,
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
