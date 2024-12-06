<?php

namespace App\Service;

use App\Entity\Coaster;
use App\Repository\CoasterRepository;
use App\Repository\MaterialTypeRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class MaterialTypeService
{
    private MaterialTypeRepository $materialTypeRepository;

    public function __construct(MaterialTypeRepository $materialTypeRepository)
    {
        $this->materialTypeRepository = $materialTypeRepository;
    }


    public function findAllMaterialTypes(): array
    {
        return $this->materialTypeRepository->findAll();
    }

    public function findMaterialTypeById(int $id): ?array
    {
        $materialType = $this->materialTypeRepository->findOneBy(['id' => $id]);

        if (!$materialType) {
            return [];
        }
        return [
            'id' => $materialType->getId(),
            'name' => $materialType->getName(),
        ];
    }

    public function findMaterialTypeByName(string $name): ?array
    {
        $materialType = $this->materialTypeRepository->findOneBy(['name' => $name]);

        if (!$materialType) {
            return [];
        }
        return [
            'id' => $materialType->getId(),
            'name' => $materialType->getName(),
        ];
    }

    public function findAll()
    {
        return $this->materialTypeRepository->findAll();
    }


}