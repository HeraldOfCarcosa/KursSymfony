<?php

namespace App\Controller;

use App\Service\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
   #[Route('/', name: 'index.home1')]
    public function home(): Response
    {
        //dump($this->getParameter('templates_dir'));
       return $this->render('index/index.html.twig');
    }
    #[Route('/code', name: 'index.home')]
    public function code(CodeGenerator $codeGenerator): Response
    {
        $code = $codeGenerator->generate();


        //$filesystem->mkdir('codes');
        //$filesystem->touch('codes/'.$code.'.txt');
        //file_put_contents('codes/'.$code.'.txt', $code);
        //$filesystem->touch('codes/12345.txt');


       // file_put_contents('codes/12345.txt', '12345');


       return $this->render('index/code.html.twig', ['code' => $code]);
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
