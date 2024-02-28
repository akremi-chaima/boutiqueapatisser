<?php

namespace App\Manager;

use App\Entity\Collection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CollectionManager
 */
class CollectionManager extends AbstractManager
{
    /**
     * CollectionManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Collection::class);
    }

    /**
     * @param Collection $object
     */
    public function save(Collection $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Collection $object
     */
    public function delete(Collection $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}