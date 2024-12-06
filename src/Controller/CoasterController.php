<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Coaster;
use App\Factory\CoasterFactory;
use App\Repository\CoasterRepository;
use App\Repository\MaterialTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CoasterController extends AbstractController
{

    private MaterialTypeRepository $materialTypeRepository;

    public function __construct(private readonly CoasterService $coasterService,
                                private readonly CoasterFactory $coasterFactory,
                                MaterialTypeRepository $materialTypeRepository,
                                CoasterRepository $coasterRepository
    )
    {
        $this->materialTypeRepository = $materialTypeRepository;
        $this->coasterRepository = $coasterRepository;
    }

    

    #[Route('/', name: 'coaster_list')]
    public function index(CoasterRepository $coasterRepository, Request $request): Response
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

        $coasters = $coasterRepository->findWithFilters($filters);

        $totalCoasters = count($coasters);
        $totalPages = (int) ceil($totalCoasters / $limit);
        $coasters = array_slice($coasters, ($currentPage - 1) * $limit, $limit);
        $allCountries = $this->coasterRepository->getEveryCountries();
        $allMaterialTypes = $this->materialTypeRepository->findAll();

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
    public function showDetails(string $name, CoasterRepository $coasterRepository): Response
    {
        $coaster = $coasterRepository->findOneBy(['name' => $name]);

        if (!$coaster) {
            throw $this->createNotFoundException('The coaster does not exist');
        }

        return $this->render('coasters/details.html.twig', [
            'coaster' => $coaster
        ]);
    }


    
}
