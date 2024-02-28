<?php

namespace App\Manager;

use App\Entity\SubCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SubCollectionManager
 */
class SubCollectionManager extends AbstractManager
{
    /**
     * SubCollectionManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, SubCollection::class);
    }

    /**
     * @param SubCollection $object
     */
    public function save(SubCollection $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param SubCollection $object
     */
    public function delete(SubCollection $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}