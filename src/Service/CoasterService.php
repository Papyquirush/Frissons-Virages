<?php

namespace App\Service;

use App\Entity\Coaster;
use App\Repository\CoasterRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CoasterService
{
    private CoasterRepository $coasterRepository;

    public function __construct(CoasterRepository $coasterRepository)
    {
        $this->coasterRepository = $coasterRepository;
    }

    public function findAllCoasters(): array
    {

        $coasters = [];
        for ($i = 1; $i <= 40; $i++) {

            $coaster = $this->findCoasterByCoasterId($i);
            if ($coaster) {
                $coasters[] = $coaster;
            }
        }
        return $coasters;
    }

    public function findCoasterByCoasterId(int $coasterId): ?Coaster
    {
        return $this->coasterRepository->findOneByCoasterId($coasterId);
    }

    public function findPaginatedCoasters(int $page, int $limit): Paginator
    {
        return $this->coasterRepository->findPaginatedCoasters($page, $limit);
    }

    public function addFavorite(Coaster $coaster)
    {
    }

    public function getFavorites()
    {
    }

    public function removeFavorite(Coaster $coaster)
    {
    }

    public function findCoasterByCoasterName(string $name)
    {
        return $this->coasterRepository->findOneBy(['name' => $name]);
    }

    public function findWithFilters(array $filters)
    {
       return $this->coasterRepository->findWithFilters($filters);
    }

    public function getEveryCountries()
    {
        return $this->coasterRepository->getEveryCountries();
    }


}