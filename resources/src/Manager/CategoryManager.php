<?php

namespace App\Manager;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CategoryManager
 */
class CategoryManager extends AbstractManager
{
    /**
     * CategoryManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(EntityManagerInterface $managerInterface)
    {
        parent::__construct($managerInterface, Category::class);
    }

    /**
     * @param Category $object
     */
    public function save(Category $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Category $object
     */
    public function delete(Category $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
}