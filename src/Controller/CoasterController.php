<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\MaterialTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;


class CoasterController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(private readonly CoasterService $coasterService,
                                EntityManagerInterface $entityManager,
                                private readonly MaterialTypeService $materialTypeService)
    {
        $this->entityManager = $entityManager;
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

        return $this->render('coasters/details.html.twig', [
            'coaster' => $coaster
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

    #[Route('/coasters', name: 'coaster_ranking')]
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
}
