<?php

namespace App\Manager;

use App\Entity\Format;
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
}