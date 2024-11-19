<?php

namespace App\Factory;

use App\Entity\Coaster;
use App\Entity\Park;
use App\Entity\Status;
use App\Entity\MaterialType;
use App\Entity\SeatingType;
use App\Entity\Model;
use App\Entity\Manufacturer;
use App\Entity\Restraint;
use App\Entity\Launches;
use Doctrine\Common\Collections\ArrayCollection;


class CoasterFactory
{
    public function createMultipleFromCaptainData(string $jsonData): array
    {
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON data: ' . json_last_error_msg());
        }


        return array_map([$this, 'createSingleFromCaptainData'], $data);;
    }

    public function createSingleFromCaptainData(array $data): Coaster
    {
        $park = new Park(
            $data['park']['name'] ?? '',
            $data['park']['country']['name'] ?? '',
            $data['park']['latitude'] ?? 0.0,
            $data['park']['longitude'] ?? 0.0
        );

        $materialType = new MaterialType($data['materialType']['name'] ?? '');
        $seatingType = new SeatingType($data['seatingType']['name'] ?? '');
        $model = new Model($data['model']['name'] ?? '');
        $manufacturer = new Manufacturer($data['manufacturer']['name'] ?? '');
        $restraint = new Restraint($data['restraint']['name'] ?? '');
        $launches = new ArrayCollection(
            array_map(fn($launch) => new Launches($launch['name'] ?? ''), $data['launchs'] ?? [])
        );
        $status = new Status($data['status']['name'] ?? '');
        $mainImage = "https://pictures.captaincoaster.com/280x210/" . ($data['mainImage']['path'] ?? '');


        return new Coaster(
            $data['name'] ?? '',
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
            new \DateTime($data['openingDate'] ?? 'now'),
            $data['totalRatings'] ?? 0,
            $data['validDuels'] ?? 0,
            (float)($data['score'] ?? 0.0),
            $data['rank'] ?? 0,
            $mainImage
        );
    }
}