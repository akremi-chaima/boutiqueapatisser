<?php

namespace App\Manager;

use App\Entity\Format;
use App\Entity\Order;
use App\Entity\OrderPastries;
use App\Entity\Pastry;
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
     * @param int $orderId
     * @return float|int|mixed[]|string
     */
    public function get(int $orderId)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('op.quantity, pastry.name as pastryName, pastry.price as pastryPrice, pastryFormat.name as formatName')
            ->from(OrderPastries::class, 'op')
            ->join(Pastry::class, 'pastry', 'WITH', 'pastry = op.pastry')
            ->join(Order::class, 'ord', 'WITH', 'ord = op.order')
            ->leftJoin(Format::class, 'pastryFormat', 'WITH', 'pastryFormat = op.format')
            ->where('op.id = :orderId')
            ->setParameter(':orderId', $orderId)
            ->getQuery()->getArrayResult();
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