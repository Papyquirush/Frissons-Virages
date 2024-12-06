<?php

namespace App\Repository;

use App\Entity\Park;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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


}