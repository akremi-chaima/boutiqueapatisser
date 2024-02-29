<?php

namespace App\Manager;

use App\DTO\Pastry\PastriesFilterDTO;
use App\Entity\Pastry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PastryManager
 */
class PastryManager extends AbstractManager
{
    /** @var PaginatorInterface */
    private $paginator;

    /**
     * PastryManager constructor.
     *
     * @param EntityManagerInterface $managerInterface
     */
    public function __construct(
        EntityManagerInterface $managerInterface,
        PaginatorInterface $paginator
    )
    {
        parent::__construct($managerInterface, Pastry::class);
        $this->paginator = $paginator;
    }

    /**
     * @param PastriesFilterDTO $dto
     * @param int $page
     * @param int $itemsPerPage
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function get(PastriesFilterDTO $dto, int $page, int $itemsPerPage) {
        $queryBuilder =  $this->getEntityManager()->createQueryBuilder()
            ->select('pastry')
            ->from(Pastry::class, 'pastry');

        $queryBuilder = $this->filterQueryBuilder($dto, $queryBuilder);

        return $this->paginator->paginate($queryBuilder, $page, $itemsPerPage);
    }

    /**
     * @param PastriesFilterDTO $dto
     * @return int
     */
    public function count(PastriesFilterDTO $dto) {
        try {
            $queryBuilder =  $this->getEntityManager()->createQueryBuilder()
                ->select('count(pastry.id)')
                ->from(Pastry::class, 'pastry');

            $queryBuilder = $this->filterQueryBuilder($dto, $queryBuilder);

            return intval($queryBuilder->getQuery()->getSingleScalarResult());
        } catch (\Exception $exception) {
            return 0;
        }
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

    /**
     * @param PastriesFilterDTO $dto
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */

    private function filterQueryBuilder(PastriesFilterDTO $dto, QueryBuilder $queryBuilder)
    {
        if (!empty($dto->getName())) {
            $queryBuilder->andWhere('pastry.name LIKE :name')
                ->setParameter(':name', '%'.$dto->getName().'%');
        }

        if (!empty($dto->getOrderBy())) {
            switch ($dto->getOrderBy()) {
                case 'asc_price':
                    $queryBuilder->orderBy('pastry.price', 'ASC');
                    break;
                case 'desc_price':
                    $queryBuilder->orderBy('pastry.price', 'DESC');
                    break;
                case 'asc_name':
                    $queryBuilder->orderBy('pastry.name', 'ASC');
                    break;
                case 'desc_name':
                    $queryBuilder->orderBy('pastry.name', 'DESC');
                    break;
            }
        }

        return $queryBuilder;
    }
}