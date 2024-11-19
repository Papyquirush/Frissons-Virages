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


        $response = $this->coasterService->getCoasters();

        $jsonData = json_encode($response);

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

    #[Route('/coaster/{id}', name: 'coaster_details')]
    #[ParamConverter('id', class: Coaster::class, options: ['id' => 'id'])]
    public function show(Coaster $coaster): Response
    {
        return $this->render('details.html.twig', [
            'coaster' => $coaster
        ]);
    }

}
