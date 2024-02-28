<?php

namespace App\Manager;

use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderStatusManager
 */
class OrderStatusManager extends AbstractManager
{
    /**
     * OrderStatusManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, OrderStatus::class);
    }

    /**
     * @param OrderStatus $object
     */
    public function save(OrderStatus $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param OrderStatus $object
     */
    public function delete(OrderStatus $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}