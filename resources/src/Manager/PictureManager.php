<?php

namespace App\Manager;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PictureManager
 */
class PictureManager extends AbstractManager
{
    /**
     * PictureManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Picture::class);
    }

    /**
     * @param Picture $object
     */
    public function save(Picture $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Picture $object
     */
    public function delete(Picture $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}