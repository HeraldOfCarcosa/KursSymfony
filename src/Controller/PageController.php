<?php

namespace App\Controller;

use App\Service\GameGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    #[Route('/gameList', name: 'page.gameList')]
    public function gameList(GameGenerator $gameGenerator): Response
    {
        $gameGenerator = $gameGenerator->gameGeneration();
        
        return $this->render('page/gameList.html.twig', [
        'gameGenerator' => $gameGenerator
        ]);
    }


    #[Route('/home', name: 'page.page')]
    public function home(): Response
    {
        $data = [
            'title' => 'Strona główna',
            'date' => new \DateTime(),
            'messages' => [
                ['id' => 1, 'text' => 'Pierwsza wiadomość', 'author' => 'Jan Kowalski'],
                ['id' => 2, 'text' => 'Druga wiadomość', 'author' => 'Anna Nowak'],
                // ...
            ],
            'numbers' => [1, 2, 3, 4, 5],
            'weather' => ['temperature' => 20, 'condition' => 'słonecznie'],
            'isPremiumUser' => false,
            'user' => ['name' => 'Jan Kowalski', 'email' => 'jan.kowalski@example.com'],
            'pageViews' => 1234,
            'popularTags' => ['symfony', 'twig', 'php', 'mvc'],
            'rating' => 4.5
        ];



        return $this->render('page/page.html.twig', [
            'data' => $data
        ]);
    }
}