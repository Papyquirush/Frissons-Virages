<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    public function findOneByName(string $name): ?Status
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): Status
    {
        $status = $this->findOneByName($name);
        if (!$status) {
            $status = new Status($name);
            $this->getEntityManager()->persist($status);
            $this->getEntityManager()->flush();
        }
        return $status;
    }
}