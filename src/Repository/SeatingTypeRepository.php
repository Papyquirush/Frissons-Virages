<?php

namespace App\Repository;

use App\Entity\SeatingType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class SeatingTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeatingType::class);
    }

    public function findOneByName(string $name): ?SeatingType
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): SeatingType
    {
        $seatingType = $this->findOneByName($name);
        if (!$seatingType) {
            $seatingType = new SeatingType($name);
            $this->getEntityManager()->persist($seatingType);
            $this->getEntityManager()->flush();
        }
        return $seatingType;
    }
}