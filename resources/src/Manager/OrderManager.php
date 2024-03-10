<?php

namespace App\Manager;

use App\DTO\Order\OrderFilterDTO;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\User;
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
     * @param OrderFilterDTO|null $dto
     * @param int|null $userId
     * @return float|int|mixed[]|string
     */
    public function get(OrderFilterDTO $dto = null, int $userId = null)
    {
        $queryBuilder =  $this->getEntityManager()->createQueryBuilder()
            ->select('ord.id, ord.createdAt, user.firstName, user.lastName, user.email, user.phoneNumber, orderStatus.name as status')
            ->from(Order::class, 'ord')
            ->join(OrderStatus::class, 'orderStatus', 'WITH', 'orderStatus = ord.orderStatus')
            ->join(User::class, 'user', 'WITH', 'user = ord.user');

        if ($dto && !empty($dto->getStatusId())) {
            $queryBuilder->andWhere('orderStatus.id = :statusId')
                ->setParameter(':statusId', $dto->getStatusId());
        }

        if ($dto && !empty($dto->getUserName())) {
            $queryBuilder->andWhere('user.lastName LIKE :userName or user.firstName LIKE :userName')
                ->setParameter(':userName', '%'.$dto->getUserName().'%');
        }

        if ($dto && !empty($dto->getDate())) {
            $queryBuilder->andWhere('ord.createdAt LIKE :createdAt')
                ->setParameter(':createdAt', '%'.$dto->getDate().'%');
        }

        if (!empty($userId)) {
            $queryBuilder->andWhere('user.id = :userId')
                ->setParameter(':userId', $userId);
        }

        return $queryBuilder->getQuery()->getArrayResult();
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