<?php

namespace App\Manager;

use App\Entity\Pastry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PastryManager
 */
class PastryManager extends AbstractManager
{
    /**
     * PastryManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Pastry::class);
    }

    /**
     * @param Pastry $object
     */
    public function save(Pastry $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Pastry $object
     */
    public function delete(Pastry $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

}