<?php

// src/Service/ParkService.php

namespace App\Service;

use App\Repository\ParkRepository;
use App\Repository\CoasterRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParkService
{
    private ParkRepository $parkRepository;
    private HttpClientInterface $httpClient;
    private RequestStack $requestStack;
    private string $token;
    private $coasterRepository;

    public function __construct(ParkRepository $parkRepository, HttpClientInterface $httpClient, RequestStack $requestStack, CoasterRepository $coasterRepository)
    {
        $this->parkRepository = $parkRepository;
        $this->coasterRepository = $coasterRepository;
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->token ="da006cd3-ed2b-4956-8180-2e955c01dbee";
    }

    public function findAllParksWithCoordinates(): array
    {
        return $this->parkRepository->findAllWithCoordinates();
    }

    public function findCoastersByPark(string $name): array
    {
        $park = $this->parkRepository->findOneBy(['name' => $name]);

        if (!$park) {
            return [];
        }

        return $this->coasterRepository->findBy(['park' => $park->getId()]);
    }


    public function findParkByName(string $name): ?array
    {
        $park = $this->parkRepository->findOneBy(['name' => $name]);

        if (!$park) {
            return [];
        }
        return [
            'id' => $park->getId(),
            'name' => $park->getName(),
            'latitude' => $park->getLatitude(),
            'longitude' => $park->getLongitude(),
        ];

    }



    public function findParkById(int $id): ?array
    {



        $response = $this->httpClient->request('GET', 'https://captaincoaster.com/api/parks/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }


        $data = $response->toArray();

        if (empty($data)) {
            return null;
        }

        return $data;
    }

    public function addFavoritePark(string $name, \App\Entity\User $user): void
    {
        $this->parkRepository->addFavoritePark($name, $user);
    }

    public function removeFavoritePark(string $name, \App\Entity\User $user): void
    {
        $this->parkRepository->removeFavoritePark($name, $user);
    }


}