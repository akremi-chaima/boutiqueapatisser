<?php

namespace App\Manager;

use App\Entity\Order;
use App\Entity\OrderPastries;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderPastriesManager
 */
class OrderPastriesManager extends AbstractManager
{
    /**
     * OrderPastriesManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, OrderPastries::class);
    }

    /**
     * @param OrderPastries $object
     */
    public function save(OrderPastries $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param OrderPastries $object
     */
    public function delete(OrderPastries $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    public function deleteOrder(Order $order)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete(OrderPastries::class, 'op')
            ->where('op.order = :order')
            ->setParameter(':order', $order);
        $qb->getQuery()->execute();

    }
}