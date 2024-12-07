<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\MaterialTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;


class CoasterController extends AbstractController
{

    public function __construct(private readonly CoasterService $coasterService,
                                private readonly MaterialTypeService $materialTypeService)
    {
    }

    #[Route('/', name: 'coaster_list')]
    public function index(Request $request): Response
    {
        $searchTerm = $request->query->get('q', '');
        $currentPage = $request->query->getInt('page', 1);
        $limit = 5;

        $filters = [
            'q' => $request->query->get('q'),
            'country' => $request->query->get('country'),
            'materialType' => $request->query->get('materialType'),
            'openingDate' => $request->query->get('openingDate'),
        ];


        $coasters = $this->coasterService->findWithFilters($filters);


        $totalCoasters = count($coasters);
        $totalPages = (int) ceil($totalCoasters / $limit);
        $coasters = array_slice($coasters, ($currentPage - 1) * $limit, $limit);
        $allCountries = $this->coasterService->getEveryCountries();
        $allMaterialTypes = $this->materialTypeService->findAll();
        $user = $this->getUser();
        if ($user instanceof User) {
            $favoriteCoasters = $this->coasterService->getFavoriteCoaster($user);
        }else {
            $favoriteCoasters = [];
        }


        return $this->render('coasters/index.html.twig', [
            'coasters' => $coasters,
            'countries' => $allCountries,
            'materialTypes' => $allMaterialTypes,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'favoriteCoasters' => $favoriteCoasters,
        ]);
    }

    #[Route('/coaster/{name}', name: 'coaster_details')]
    public function showDetails(string $name): Response
    {
        $coaster = $this->coasterService->findCoasterByCoasterName($name);

        if (!$coaster) {
            throw $this->createNotFoundException('The coaster does not exist');
        }

        $user = $this->getUser();
        if ($user instanceof User) {
            $favoriteCoasters = $this->coasterService->getFavoriteCoaster($user);
        }else {
            $favoriteCoasters = [];
        }

        return $this->render('coasters/details.html.twig', [
            'coaster' => $coaster,
            'favoriteCoasters' => $favoriteCoasters,
        ]);
    }

    #[Route('/favorite/coaster/add/{name}', name: 'favorite_coaster_add')]
    public function addFavoriteCoaster(string $name): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->redirectToRoute('app_login');
        }
        $this->coasterService->addFavoriteCoaster($name, $user);

        return $this->redirectToRoute('favorite_coaster_list');
    }

    #[Route('/favorite/coaster/remove/{name}', name: 'favorite_coaster_remove')]
    public function removeFavoriteCoaster(string $name): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->redirectToRoute('app_login');
        }
        $this->coasterService->removeFavoriteCoaster($name, $user);

        return $this->redirectToRoute('favorite_coaster_list');
    }

    #[Route('/ranking', name: 'coaster_ranking')]
    public function ranking(Request $request)
    {
        $currentPage = $request->query->getInt('page', 1); 
        $limit = 10; 

        $coasters= $this->coasterService->findRankedCoasters();
        $totalCoasters = count($coasters);
        $totalPages = ceil($totalCoasters / $limit);


        $coasters = array_slice($coasters, ($currentPage - 1) * $limit, $limit);

        return $this->render('ranking/index.html.twig', [
            'coasters' => $coasters,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/versus', name: 'coaster_versus')]
    public function versus(Request $request): Response
    {
        $coasters = $this->coasterService->findAllCoasters();
        $selectedCoaster1 = null;
        $selectedCoaster2 = null;
        
        $coaster1Id = $request->query->get('coaster1');
        $coaster2Id = $request->query->get('coaster2');
        
        if ($coaster1Id) {
            $selectedCoaster1 = $this->coasterService->findCoasterByCoasterName($coaster1Id);
        }
        if ($coaster2Id) {
            $selectedCoaster2 = $this->coasterService->findCoasterByCoasterName($coaster2Id);
        }
        
        return $this->render('versus/index.html.twig', [
            'coasters' => $coasters,
            'selectedCoaster1' => $selectedCoaster1,
            'selectedCoaster2' => $selectedCoaster2
        ]);
    }
}
