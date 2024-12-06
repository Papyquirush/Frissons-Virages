<?php
//
//declare(strict_types=1);
//
//namespace App\Controller;
//
//use App\Entity\Park;
//use App\Factory\ParkFactory;
//use App\Repository\ParkRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
////use App\Service\ParkService;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
//
//class ParkController extends AbstractController
//{
//
//    public function __construct(//private readonly ParkService $parkService,
//                                private readonly ParkFactory $coasterFactory
//    )
//    {}
//
//    #[Route('/parc-liste', name: 'park_list')]
//    public function index(ParkRepository $parkRepository, Request $request): Response
//    {
//        $searchTerm = $request->query->get('q', '');
//        $currentPage = $request->query->getInt('page', 1);
//        $limit = 5;
//
//        $parks = $parkRepository->findBySearchTerm($searchTerm);
//
//        // Pagination (simulation manuelle)
//        $totalParks = count($park);
//        $totalPages = (int) ceil($totalParks / $limit);
//        $parks = array_slice($parks, ($currentPage - 1) * $limit, $limit);
//
//        return $this->render('parks/index.html.twig', [
//            'parks' => $parks,
//            'currentPage' => $currentPage,
//            'totalPages' => $totalPages,
//        ]);
//    }
//
//    #[Route('/carte', name: 'coaster_carte')]
//    public function map(): Response
//    {
//
//
//        return $this->render('carte.html.twig');
//    }
//
//    #[Route('/park/{name}', name: 'park_details')]
//    public function showDetails(string $name, ParkRepository $parkRepository): Response
//    {
//        $park = $parkRepository->findOneBy(['name' => $name]);
//
//        if (!$park) {
//            throw $this->createNotFoundException('The park does not exist');
//        }
//
//        return $this->render('parks/details.html.twig', [
//            'park' => $park
//        ]);
//    }
//}
