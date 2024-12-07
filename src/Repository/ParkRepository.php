<?php

namespace App\Repository;

use App\Entity\Park;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ParkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Park::class);
    }

    public function findOneByName(string $name): ?Park
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $id, string $name, string $country, float $latitude, float $longitude): Park
    {
        $park = $this->findOneByName($name);
        if (!$park) {
            $park = new Park($id, $name, $country, $latitude, $longitude);
            $this->getEntityManager()->persist($park);
            $this->getEntityManager()->flush();
        }
        return $park;
    }


    public function findAllWithCoordinates(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.latitude IS NOT NULL')
            ->andWhere('p.longitude IS NOT NULL')
            ->andWhere('p.latitude != 0 AND p.longitude != 0')
            ->getQuery()
            ->getResult();
    }


    public function findByName(string $name): ?Park
    {
        return $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPaginated(int $page = 1, int $limit = 10, ?string $search = null, ?string $country = null): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($search) {
            $qb->andWhere('p.name LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($country) {
            $qb->andWhere('p.country = :country')
               ->setParameter('country', $country);
        }

        $qb->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit);

        $paginator = new Paginator($qb);

        return [
            'parks' => iterator_to_array($paginator->getIterator()),
            'totalItems' => $paginator->count()
        ];
    }

      public function findAllCountries(): array
      {
          return $this->createQueryBuilder('p')
              ->select('DISTINCT p.country')
              ->orderBy('p.country', 'ASC')
              ->getQuery()
              ->getSingleColumnResult();
      }

    public function removeFavoritePark(string $name, \App\Entity\User $user): void
    {
        $park = $this->findOneBy(['name' => $name]);

        $user->removePark($park);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function addFavoritePark(string $name, \App\Entity\User $user): void
    {
        $park = $this->findOneBy(['name' => $name]);

        $user->addPark($park);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }



}