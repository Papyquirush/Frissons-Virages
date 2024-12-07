<?php

declare(strict_types=1);

namespace App\Controller;

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
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user is not an instance of \App\Entity\User.');
        }
        $favoriteCoasters = $this->coasterService->getFavoriteCoaster($user);

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
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user is not an instance of \App\Entity\User.');
        }
        $this->coasterService->addFavoriteCoaster($name, $user);

        return $this->redirectToRoute('favorite_coaster_list');
    }

    #[Route('/favorite/coaster/remove/{name}', name: 'favorite_coaster_remove')]
    public function removeFavoriteCoaster(string $name): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user is not an instance of \App\Entity\User.');
        }
        $this->coasterService->removeFavoriteCoaster($name, $user);

        return $this->redirectToRoute('favorite_coaster_list');
    }



}
