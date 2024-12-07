<?php

namespace App\Controller;


use App\Service\CoasterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class FavoriteController extends AbstractController
{



    public function __construct(private readonly CoasterService $coasterService)
    {

    }

    #[Route('/favorite/coaster', name: 'favorite_coaster_list')]
    public function getFavoriteCoaster(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user is not an instance of \App\Entity\User.');
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
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user is not an instance of \App\Entity\User.');
        }
        $parks = $this->coasterService->getFavoritePark($user);


        return $this->render('favorite/park.html.twig', [
            'parks' => $parks
        ]);
    }






}
