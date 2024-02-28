<?php

namespace App\Manager;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RoleManager
 */
class RoleManager extends AbstractManager
{
    /**
     * RoleManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Role::class);
    }

    /**
     * @param Role $object
     */
    public function save(Role $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Role $object
     */
    public function delete(Role $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}