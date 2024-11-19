<?php

namespace App\Repository;

use App\Entity\Launches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LaunchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Launches::class);
    }

    public function findOneByName(string $name): ?Launches
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): Launches
    {
        $launch = $this->findOneByName($name);
        if (!$launch) {
            $launch = new Launches($name);
            $this->getEntityManager()->persist($launch);
            $this->getEntityManager()->flush();
        }
        return $launch;
    }
}
