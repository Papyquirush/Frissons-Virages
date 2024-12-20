<?php

namespace App\Repository;

use App\Entity\Coaster;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class CoasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }

    public function findOneByCoasterId(int $coasterId): ?Coaster
    {
        return $this->findOneBy(['idCoaster' => $coasterId]);
    }

    public function findBySearchTerm(string $searchTerm)
    {
        $qb = $this->createQueryBuilder('c');

        if ($searchTerm) {
            $qb->andWhere('c.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findPaginatedCoasters(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query);
    }

    public function getEveryCountries()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT DISTINCT p.country
            FROM App\Entity\Coaster c
            JOIN c.park p'
        );

        $results = $query->getResult();
        $countries = array_map(function($result) {
            return $result['country'];
        }, $results);

        return $countries;
    }

    public function findWithFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.materialType', 'mt')
            ->leftJoin('c.park', 'p')
            ->addSelect('p')
            ->addSelect('mt');

        if (!empty($filters['q'])) {
            $qb->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $filters['q'] . '%');
        }

        if (!empty($filters['country'])) {
            $qb->andWhere('p.country = :country')
                ->setParameter('country', $filters['country']);
        }

        if (!empty($filters['materialType'])) {
            $qb->andWhere('mt.id = :materialType')
                ->setParameter('materialType', $filters['materialType']);
        }

        if (!empty($filters['openingDate'])) {
            $qb->andWhere('c.openingDate >= :openingDate')
                ->setParameter('openingDate', new \DateTime($filters['openingDate']));
        }

        return $qb->getQuery()->getResult();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult();
    }

    public function findRankedCoasters(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.rank != :rank')
            ->setParameter('rank', 0)
            ->orderBy('c.rank', 'ASC')
            ->getQuery()
            ->getResult();
    }



    public function addFavoriteCoaster(string $name,User $user): void
    {
        $coaster = $this->findOneBy(['name' => $name]);

        $user->addCoaster($coaster);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();



    }

    public function removeFavoriteCoaster(string $name, User $user): void
    {
        $coaster = $this->findOneBy(['name' => $name]);

        $user->removeCoaster($coaster);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getFavoriteCoaster(User $user): Collection
    {
        return $user->getCoaster();
    }



}