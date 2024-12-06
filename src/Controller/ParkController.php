<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ParkService;

class ParkController extends AbstractController
{
    private ParkService $parkService;

    public function __construct(ParkService $parkService)
    {
        $this->parkService = $parkService;
    }

    #[Route('/api/parks', name: 'api_parks')]
    public function getParks(): JsonResponse
    {
        $parks = $this->parkService->findAllParksWithCoordinates();
        return $this->json($parks);
    }

    #[Route('/api/parks/{name}', name: 'api_park')]
    public function getPark(string $name): JsonResponse
    {

        $park = $this->parkService->findParkByName($name);
        return $this->json($park);
    }


    #[Route('/api/parks/{name}/coasters', name: 'api_park_coasters')]
    public function getCoastersByPark(string $name): JsonResponse
    {
        $coasters = $this->parkService->findCoastersByPark($name);
        return $this->json($coasters);
    }

    #[Route('/carte', name: 'park_carte')]
    public function map(): Response
    {
        return $this->render('carte.html.twig');
    }


    #[Route('/carte/{name}', name: 'park_carte_id')]
    public function mapId(string $name): Response
    {
        return $this->render('carteId.html.twig', ['name' => $name]);
    }

}
