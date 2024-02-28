<?php

namespace App\Manager;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderManager
 */
class OrderManager extends AbstractManager
{
    /**
     * OrderManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Order::class);
    }

    /**
     * @param Order $object
     */
    public function save(Order $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Order $object
     */
    public function delete(Order $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}