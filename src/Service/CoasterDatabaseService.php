<?php

namespace App\Service;

use App\Factory\CoasterFactory;
use Doctrine\ORM\EntityManagerInterface;

class CoasterDatabaseService
{
    private EntityManagerInterface $entityManager;
    private CoasterFactory $coasterFactory;

    public function __construct(EntityManagerInterface $entityManager, CoasterFactory $coasterFactory)
    {
        $this->entityManager = $entityManager;
        $this->coasterFactory = $coasterFactory;
    }

    public function saveCoasters(array $coasterData): void
    {
        foreach ($coasterData as $data) {
            if(!empty($coasterData)) {
                $coaster = $this->coasterFactory->createSingleFromCaptainData($data);
                $this->entityManager->persist($coaster);
            }
        }

        $this->entityManager->flush();
    }
}