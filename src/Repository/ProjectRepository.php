<?php

namespace App\Repository;

use App\DTO\ProjectFilter;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Project::class);
    }

    /*
    * @return array{items: Project[], total: int}
    */
    public function findFiltered(ProjectFilter $filter, int $page, int $perPage): array {
        $countQb = $this->createQueryBuilder("p")->select('COUNT(p.id)');

        $this->applyFilters($countQb, $filter);

        $total = (int) $countQb->getQuery()->getSingleScalarResult();

        $listQb = $this->createQueryBuilder('p')->orderBy('p.id', 'ASC');

        $this->applyFilters($listQb, $filter);

        $listQb->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);

        $items = $listQb->getQuery()->getResult();

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function applyFilters(QueryBuilder $qb, ProjectFilter $filter): void {
        if($filter->areaMin !== null) {
            $qb->andWhere('p.area >= :areaMin')->setParameter('areaMin', $filter->areaMin);
        }
        if($filter->areaMax !== null) {
            $qb->andWhere('p.area =< :areaMax')->setParameter('areaMax', $filter->areaMax);
        }
        if(!empty($filter->floors)) {
            $qb->andWhere('p.floors IN (:floors)')->setParameter('floors', $filter->floors);
        }
        if($filter->hasPool !== null) {
            $qb->andWhere('p.hasPool = :hasPool')->setParameter('hasPool', $filter->hasPool);
        }
    }
}