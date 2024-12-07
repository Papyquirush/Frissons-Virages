<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\CoasterService;
use App\Service\ParkService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class FavoriteController extends AbstractController
{



    public function __construct(private readonly CoasterService $coasterService, private readonly ParkService $parkService)
    {

    }

    #[Route('/favorite/coaster', name: 'favorite_coaster_list')]
    public function getFavoriteCoaster(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->redirectToRoute('app_login');
        }
        $coasters = $this->coasterService->getFavoriteCoaster($user);


        return $this->render('favorite/coaster.html.twig', [
            'coasters' => $coasters
        ]);
    }

    #[Route('/favorite/park', name: 'favorite_park_list')]
    public function getFavoritePark(): Response
    {

        $user = $this->getUser();
        if (!$user instanceof User) {
             $this->redirectToRoute('app_login');
        }
        $parks = $this->parkService->getFavoriteParkS($user);


        return $this->render('favorite/park.html.twig', [
            'parks' => $parks
        ]);
    }






}
