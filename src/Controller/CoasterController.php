<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Coaster;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CoasterController extends AbstractController
{

    public function __construct(private readonly CoasterService $coasterService,

    )
    {}

    #[Route('/', name: 'coaster_list')]
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;


        $paginator = $this->coasterService->findPaginatedCoasters($page, $limit);
        $totalCoasters = count($paginator);
        $totalPages = ceil($totalCoasters / $limit);


        return $this->render('index.html.twig', [
            'coasters' => iterator_to_array($paginator)/*$coasters*/,
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

}
