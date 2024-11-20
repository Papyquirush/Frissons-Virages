<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoasterService
{
    private HttpClientInterface $httpClient;
    private RequestStack $requestStack;
    private string $token;

    public function __construct(HttpClientInterface $httpClient, RequestStack $requestStack)
    {
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->token ="da006cd3-ed2b-4956-8180-2e955c01dbee";

    }

    public function getCoasters(): array
    {
        $coasters = [];
        for ($i = 1; $i <= 20; $i++) {
            $coasters[] = $this->getCoasterById($i);
        }
        return $coasters;

    }

    public function getCoasterById(int $id): array
    {
        try {
        $response = $this->httpClient->request('GET', 'https://captaincoaster.com/api/coasters/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);
        return $response->toArray();
    }catch (\Exception $e){
        return [];
    }
    }


    public function getNbCoasters(): int
    {
        $response = $this->httpClient->request('GET', 'https://captaincoaster.com/api/coasters', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);

        $data = $response->toArray();


        return $data["hydra:totalItems"];

    }


}