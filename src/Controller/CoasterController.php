<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\CoasterFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CoasterService;

class CoasterController extends AbstractController
{

    public function __construct(private readonly CoasterService $coasterService,
                                private readonly CoasterFactory $coasterFactory
    )
    {}

    #[Route('/coasters', name: 'app_coaster_index')]
    public function index(): Response
    {
        $response = $this->coasterService->getCoasters();

        dump($response);
        $jsonData = json_encode($response);
        $coasters = $this->coasterFactory->createMultipleFromCaptainData($jsonData);

        return $this->render('base.html.twig', [
            'coasters' => $coasters
        ]);
    }
}
