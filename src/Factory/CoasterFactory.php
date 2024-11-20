<?php

namespace App\Factory;

use App\Entity\Coaster;
use App\Repository\MaterialTypeRepository;
use App\Repository\SeatingTypeRepository;
use App\Repository\ModelRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\RestraintRepository;
use App\Repository\LaunchesRepository;
use App\Repository\ParkRepository;
use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;

class CoasterFactory
{
    private MaterialTypeRepository $materialTypeRepository;
    private SeatingTypeRepository $seatingTypeRepository;
    private ModelRepository $modelRepository;
    private ManufacturerRepository $manufacturerRepository;
    private RestraintRepository $restraintRepository;
    private LaunchesRepository $launchesRepository;
    private ParkRepository $parkRepository;
    private StatusRepository $statusRepository;

    public function __construct(
        MaterialTypeRepository $materialTypeRepository,
        SeatingTypeRepository $seatingTypeRepository,
        ModelRepository $modelRepository,
        ManufacturerRepository $manufacturerRepository,
        RestraintRepository $restraintRepository,
        LaunchesRepository $launchesRepository,
        ParkRepository $parkRepository,
        StatusRepository $statusRepository
    ) {
        $this->materialTypeRepository = $materialTypeRepository;
        $this->seatingTypeRepository = $seatingTypeRepository;
        $this->modelRepository = $modelRepository;
        $this->manufacturerRepository = $manufacturerRepository;
        $this->restraintRepository = $restraintRepository;
        $this->launchesRepository = $launchesRepository;
        $this->parkRepository = $parkRepository;
        $this->statusRepository = $statusRepository;
    }

    public function createMultipleFromCaptainData(string $jsonData): array
    {
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON data: ' . json_last_error_msg());
        }

        return array_map([$this, 'createSingleFromCaptainData'], $data);
    }

    public function createSingleFromCaptainData(array $data): Coaster
    {
        $park = $this->parkRepository->findOrCreate(
            $data['park']['id'] ?? '',
            $data['park']['name'] ?? '',
            $data['park']['country']['name'] ?? '',
            $data['park']['latitude'] ?? 0.0,
            $data['park']['longitude'] ?? 0.0
        );

        $materialType = $this->materialTypeRepository->findOrCreate($data['materialType']['name'] ?? '');

        $seatingType = $this->seatingTypeRepository->findOrCreate($data['seatingType']['name'] ?? '');

        $model = $this->modelRepository->findOrCreate($data['model']['name'] ?? '');

        $manufacturer = $this->manufacturerRepository->findOrCreate($data['manufacturer']['name'] ?? '');

        $restraint = $this->restraintRepository->findOrCreate($data['restraint']['name'] ?? '');

        $launches = new ArrayCollection(
            array_map(fn($launch) => $this->launchesRepository->findOrCreate($launch['name'] ?? ''), $data['launchs'] ?? [])
        );

        $status = $this->statusRepository->findOrCreate($data['status']['name'] ?? '');

        $mainImage = "https://pictures.captaincoaster.com/280x210/" . ($data['mainImage']['path'] ?? '');

        $openingDate = isset($data['openingDate']) ? new \DateTime($data['openingDate']) : new \DateTime('0001-01-01');;


        return new Coaster(
            $data['id'],
            $data['name'],
            $materialType,
            $seatingType,
            $model,
            $data['speed'] ?? 0,
            $data['height'] ?? 0,
            $data['length'] ?? 0,
            $data['inversionsNumber'] ?? 0,
            $manufacturer,
            $restraint,
            $launches,
            $park,
            $status,
            $openingDate,
            $data['totalRatings'],
            $data['validDuels'],
            (float)($data['score'] ?? 0.0),
            $data['rank'] ?? 0,
            $mainImage
        );
    }
}