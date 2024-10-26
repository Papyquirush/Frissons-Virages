<?php

namespace App\Factory;

use App\Entity\Coaster;
use App\Entity\Park;

class CoasterFactory
{
    public function createMultipleFromCaptainData(string $jsonData): array
    {
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON data: ' . json_last_error_msg());
        }

        $coasters = [];
        foreach ($data['hydra:member'] as $coasterData) {
            $coasters[] = $this->createSingleFromCaptainData($coasterData);
        }
        return $coasters;
    }

    public function createSingleFromCaptainData(array $data): Coaster
    {
        $park = new Park(
            $data['park']['name'] ?? '',
            $data['park']['country']['name'] ?? '',
            $data['park']['latitude'] ?? 0.0,
            $data['park']['longitude'] ?? 0.0
        );


        return new Coaster(
            $data['name'] ?? '',
            $data['materialType']['name'] ?? '',
            $data['seatingType']['name'] ?? '',
            $data['model']['name'] ?? '',
            $data['speed'] ?? 0,
            $data['height'] ?? 0,
            $data['length'] ?? 0,
            $data['inversionsNumber'] ?? 0,
            $data['manufacturer']['name'] ?? '',
            $data['restraint']['name'] ?? '',
            array_map(fn($launch) => $launch['name'] ?? '', $data['launchs'] ?? []),
            $park,
            $data['status']['name'] ?? '',
            new \DateTime($data['openingDate'] ?? 'now'),
            $data['totalRatings'] ?? 0,
            $data['validDuels'] ?? 0,
            (float)($data['score'] ?? 0.0),
            $data['rank'] ?? 0,
            $data['mainImage']['path'] ?? ''
        );
    }
}