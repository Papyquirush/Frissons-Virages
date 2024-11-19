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
}