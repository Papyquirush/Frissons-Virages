<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function findOneByName(string $name): ?Model
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOrCreate(string $name): Model
    {
        $model = $this->findOneByName($name);
        if (!$model) {
            $model = new Model($name);
            $this->getEntityManager()->persist($model);
            $this->getEntityManager()->flush();
        }
        return $model;
    }
}