<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/games/new', name: 'app_game_new')]
    public function index(EntityManagerInterface $entityManager, HttpFoundationRequest $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $game = new Game();
        /*$game->setName('TFT')
             ->setDescription('lorem ipsium,lorem ipsium,lorem ipsium,lorem ipsium,lorem ipsium,')
             ->setScore(7)
             ->setReleaseDate(new \DateTime('2020-08-12'));
*/
        $form = $this->createForm(GameFormType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Everything went well'
            );

            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }

        return $this->render('game/new.html.twig', [
            'form' => $form,
        ]);



      #  dd($form);


      #  $entityManager->getRepository(Game::class)->save($game, true);

        #return new Response('Saved new game with id'.$game->getId());
    }

    #[Route('/games/edit/{id}', name: 'edit_game')]
    public function editgame(Game $game, EntityManagerInterface $entityManager, HttpFoundationRequest $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(GameFormType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $game = $form->getData();

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Everything went well'
            );

            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }

        return $this->render('game/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game, int $id) : Response 
    {       
        return $this->render('game/show.html.twig', [
            'game'=> $game,
        ]);
    }

    #[Route('/games', name: 'app_game_list')]
    public function list(EntityManagerInterface $entityManager) : Response 
    {
        $this->denyAccessUnlessGranted('ROLE_USER');




        $games = $entityManager->getRepository(Game::class)->findAll();
        
        return $this->render('game/list.html.twig', [
            'games'=> $games,
        ]);
    }

    #[Route('/games/top', name: 'app_game_top_list')]
    public function topList(EntityManagerInterface $entityManager) : Response 
    {
        $games = $entityManager->getRepository(Game::class)->findAllEqualScoreSql();
        
        return $this->render('game/toplist.html.twig', [
            'games'=> $games,
        ]);
    }



    #[Route('/game/edit/{id}', name: 'app_game_edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if(!$game)
        {
            throw $this->createNotFoundException(
                'No game found for id '. $id
            );
        }

        $game->setScore(9);

        $entityManager->flush();

        return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
    }

    #[Route('/game/delete/{id}', name: 'app_game_edit')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $game = $entityManager->getRepository(Game::class)->find($id);

        if(!$game)
        {
            throw $this->createNotFoundException(
                'No game found for id '. $id
            );
        }

        $entityManager->remove($game);
        $entityManager->flush();


        return $this->redirectToRoute('app_game_list');
    }
}
