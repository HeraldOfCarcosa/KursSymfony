<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
   #[Route('/', name: 'index.home')]
    public function home(): Response
    {
       return $this->render('index/index.html.twig');
    }

    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig' );
    }

    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = "Guest"): Response
    {
        $favouriteGames = [
            'CS:GO',
            'Wow'
        ];
        return $this->render('index/home.html.twig', [
            'firstName' => $firstName,
            'favouriteGames' => $favouriteGames
            ]);
    }

    //Generacja zwrotu JSONa
    #[Route('/top', name: 'index.top')]
    public function top()
    {
        $topGames = [
            'CS:GO',
            'Wow'
        ];


        return new JsonResponse($topGames);
    }
}
