<?php

namespace App\Repository;

use App\Entity\MaterialType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MaterialTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialType::class);
    }

    public function findOneByName(string $name): ?MaterialType
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): MaterialType
    {
        $materialType = $this->findOneByName($name);
        if (!$materialType) {
            $materialType = new MaterialType($name);
            $this->getEntityManager()->persist($materialType);
            $this->getEntityManager()->flush();
        }
        return $materialType;
    }
}