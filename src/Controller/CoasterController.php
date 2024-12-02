<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Coaster;
use App\Factory\CoasterFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CoasterController extends AbstractController
{

    public function __construct(private readonly CoasterService $coasterService,
                                private readonly CoasterFactory $coasterFactory
    )
    {}

    #[Route('/', name: 'coaster_list')]
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;


        $response = $this->coasterService->findAllCoasters();
        $coastersArray = array_map(fn($coaster) => $coaster->toArray(), $response);
        $jsonData = json_encode($coastersArray);
        $coasters = $this->coasterFactory->createMultipleFromCaptainData($jsonData);

        $totalCoasters = count($coasters);
        $totalPages = ceil($totalCoasters / $limit);
        $offset = ($page - 1) * $limit;
        $coasters = array_slice($coasters, $offset, $limit);


        return $this->render('index.html.twig', [
            'coasters' => $coasters,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/coaster/{coaster}', name: 'coaster_details')]
    public function showDetails(Coaster $coaster): Response
    {
        return $this->render('details.html.twig', [
            'coaster' => $coaster
        ]);
    }



    #[Route('/carte', name: 'coaster_carte')]
    public function map(): Response
    {



        return $this->render('carte.html.twig');
    }

}
