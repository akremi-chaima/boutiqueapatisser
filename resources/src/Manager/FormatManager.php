<?php

namespace App\Manager;

use App\Entity\Format;
use App\Entity\Pastry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FormatManager
 */
class FormatManager extends AbstractManager
{
    /**
     * FormatManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Format::class);
    }

    /**
     * @param Format $object
     */
    public function save(Format $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Format $object
     */
    public function delete(Format $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    public function deleteFormat(Pastry $pastry)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete(Format::class, 'f')
            ->where('f.pastry = :pastry')
            ->setParameter(':pastry', $pastry);
        $qb->getQuery()->execute();

    }
}