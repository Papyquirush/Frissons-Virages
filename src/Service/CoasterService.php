<?php

namespace App\Service;

use App\Entity\Coaster;
use App\Entity\User;
use App\Repository\CoasterRepository;
use Doctrine\Common\Collections\Collection;
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

    public function findCoasterByCoasterName(string $name)
    {
        return $this->coasterRepository->findOneBy(['name' => $name]);
    }

    public function findWithFilters(array $filters): array
    {
       return $this->coasterRepository->findWithFilters($filters);
    }

    public function getEveryCountries(): array
    {
        return $this->coasterRepository->getEveryCountries();
    }

    public function addFavoriteCoaster(string $name, User $user): void
    {
        $this->coasterRepository->addFavoriteCoaster($name, $user);
    }

    public function removeFavoriteCoaster(string $name, User $user): void
    {
        $this->coasterRepository->removeFavoriteCoaster($name, $user);
    }

    public function getFavoriteCoaster(User $user): Collection
    {
        return $this->coasterRepository->getFavoriteCoaster($user);
    }

    public function findRankedCoasters(): array
    {
        return $this->coasterRepository->findRankedCoasters();
    }

}