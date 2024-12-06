<?php

namespace App\Service;

use App\Entity\Park;
use App\Repository\ParkRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkDatabaseService
{
    private EntityManagerInterface $entityManager;
    private ParkRepository $parkRepository;

    public function __construct(EntityManagerInterface $entityManager, ParkRepository $parkRepository)
    {
        $this->entityManager = $entityManager;
        $this->parkRepository = $parkRepository;
    }

    public function updateParks(string $name, array $newData): ?Park
    {
        $park = $this->parkRepository->findByName($name);

        if (!$park) {
            return null;
        }

        if (isset($newData['country'])) {
            $country = is_array($newData['country']) ? $newData['country']['name'] : $newData['country'];
            $park->setCountry($country);
        }
        if (isset($newData['latitude'])) {
            $park->setLatitude($newData['latitude']);
        }
        if (isset($newData['longitude'])) {
            $park->setLongitude($newData['longitude']);
        }

        $this->entityManager->flush();

        return $park;
    }
}