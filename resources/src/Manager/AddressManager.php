<?php

namespace App\Manager;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AddressManager
 */
class AddressManager extends AbstractManager
{
    /**
     * AddressManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Address::class);
    }

    /**
     * @param Address $object
     */
    public function save(Address $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Address $object
     */
    public function delete(Address $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}