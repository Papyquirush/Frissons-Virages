<?php

namespace App\Repository;

use App\Entity\Restraint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RestraintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restraint::class);
    }

    public function findOneByName(string $name): ?Restraint
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): Restraint
    {
        $restraint = $this->findOneByName($name);
        if (!$restraint) {
            $restraint = new Restraint($name);
            $this->getEntityManager()->persist($restraint);
            $this->getEntityManager()->flush();
        }
        return $restraint;
    }
}