<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ParkService;
use Symfony\Component\HttpFoundation\Request;

class ParkController extends AbstractController
{

    public function __construct(private readonly ParkService $parkService)
    {
    }


    #[Route('/parks', name: 'park_list')]
    public function index(Request $request): Response
    {
        $currentPage = $request->query->getInt('page', 1);
        $search = $request->query->get('q');
        $country = $request->query->get('country');
        $limit = 10;
        
        $result = $this->parkService->getPaginatedParks($currentPage, $limit, $search, $country);
        $countries = $this->parkService->getAllCountries();

        $totalPages = (int) ceil($result['totalItems'] / $limit);

        $user = $this->getUser();
        if ($user instanceof User) {
            $favoriteParks = $this->parkService->getFavoriteParks($user);
        } else {
            $favoriteParks = [];
        }



        return $this->render('parks/index.html.twig', [
            'parks' => $result['parks'],
            'countries' => $countries,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'favoriteParks' => $favoriteParks
        ]);
    }

    #[Route('/park/{name}', name: 'park_details')]
    public function showDetails(string $name): Response
    {
        $park = $this->parkService->findParkByName($name);

        if (!$park) {
            throw $this->createNotFoundException('The park does not exist');
        };

        $user = $this->getUser();
        if ($user instanceof User) {
            $favoriteParks = $this->parkService->getFavoriteParks($user);
        } else {
            $favoriteParks = [];
        }


        return $this->render('parks/details.html.twig', [
            'park' => $park,
            'favoriteParks' => $favoriteParks
        ]);
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

    #[Route('/map', name: 'park_map')]
    public function map(): Response
    {
        return $this->render('map/map.html.twig');
    }


    #[Route('/map/{name}', name: 'park_map_id')]
    public function mapId(string $name): Response
    {
        return $this->render('map/mapId.html.twig', ['name' => $name]);
    }

    #[Route('/favorite/park/add/{name}', name: 'favorite_park_add')]
    public function addFavoritePark(string $name): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->redirectToRoute('app_login');
        }
        $this->parkService->addFavoritePark($name, $user);
        return $this->redirectToRoute('favorite_park_list', ['name' => $name]);
    }

    #[Route('/favorite/park/remove/{name}', name: 'favorite_park_remove')]
    public function removeFavoritePark(string $name): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->redirectToRoute('app_login');
        }
        $this->parkService->removeFavoritePark($name, $user);
        return $this->redirectToRoute('favorite_park_list', ['name' => $name]);
    }


}
