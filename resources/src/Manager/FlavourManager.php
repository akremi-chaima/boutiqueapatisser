<?php

namespace App\Manager;

use App\Entity\Flavour;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FlavourManager
 */
class FlavourManager extends AbstractManager
{
    /**
     * FlavourManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Flavour::class);
    }

    /**
     * @param Flavour $object
     */
    public function save(Flavour $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Flavour $object
     */
    public function delete(Flavour $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}