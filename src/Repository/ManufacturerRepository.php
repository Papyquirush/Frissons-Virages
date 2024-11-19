<?php

namespace App\Repository;

use App\Entity\Manufacturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ManufacturerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manufacturer::class);
    }

    public function findOneByName(string $name): ?Manufacturer
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): Manufacturer
    {
        $manufacturer = $this->findOneByName($name);
        if (!$manufacturer) {
            $manufacturer = new Manufacturer($name);
            $this->getEntityManager()->persist($manufacturer);
            $this->getEntityManager()->flush();
        }
        return $manufacturer;
    }
}
