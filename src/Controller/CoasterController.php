<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Coaster;
use App\Service\MaterialTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

        return $this->render('coasters/index.html.twig', [
            'coasters' => $coasters,
            'countries' => $allCountries,
            'materialTypes' => $allMaterialTypes,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/carte', name: 'coaster_carte')]
    public function map(): Response
    {


        return $this->render('carte.html.twig');
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



    #[Route('/favorite', name: 'favorite_list')]
    public function listFavorite(): Response
    {
        $favorites = $this->coasterService->getFavorites();

        return $this->render('coasters/favorites.html.twig', [
            'favorites' => $favorites
        ]);
    }

    #[Route('/favorite/add/{name}', name: 'favorite_add')]
    public function addFavorite(Coaster $coaster): Response
    {
        $this->coasterService->addFavorite($coaster);

        return $this->redirectToRoute('coaster_list');
    }

    #[Route('/favorite/remove/{name}', name: 'favorite_remove')]
    public function removeFavorite(Coaster $coaster): Response
    {
        $this->coasterService->removeFavorite($coaster);

        return $this->redirectToRoute('favorite_list');
    }



    
}
