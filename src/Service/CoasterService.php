<?php

namespace App\Service;

use App\Entity\Coaster;
use App\Repository\CoasterRepository;

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
}