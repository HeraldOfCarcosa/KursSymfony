<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Comments;
use App\Form\NewsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{

    #[Route('/newsList', name: 'news_list')]
    public function newsList(EntityManagerInterface $entityManager) : Response 
    {
        $allArticles = $entityManager->getRepository(News::class)->findAll();
        
        $articlesWithComments = [];
        foreach ($allArticles as $article) {
        $comments = $article->getComments();
        $articlesWithComments[] = [
            'article' => $article,
            'comments' => $comments,
        ];
    }

    return $this->render('news/newsList.html.twig', [
        'articlesWithComments' => $articlesWithComments,
    ]);
    }
    /*
    #[Route('/newsList', name: 'news_list')]
    public function newsList(EntityManagerInterface $entityManager) : Response 
    {
        $allArticles = $entityManager->getRepository(News::class)->findAll();

        return $this->render('news/newsList.html.twig', [
            'allArticles' => $allArticles
        ]);
    }
    */

    #[Route('/news/new', name: 'news_add')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADD');
        $News = new News();
        $form = $this->createForm(NewsFormType::class, $News);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $News = $form->getData();
            $News->setPublicationTime(new \DateTime());
            $entityManager->getRepository(NewsFormType::class)->save($News);

            $this->addFlash(
                'success',
                'News article created!'
            );

            return $this->redirectToRoute('news_list', ['id' => $News->getId()]);
        }

        return $this->render('news/newNews.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/news/edit/{id}', name: 'news_edit')]
    public function edit(News $News, EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDIT');
        $form = $this->createForm(NewsFormType::class, $News);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $News = $form->getData();
            $entityManager->getRepository(NewsFormType::class)->save($News);

            $this->addFlash('success', 'News article updated!');

            return $this->redirectToRoute('news_list', ['id' => $News->getId()]);
        }

        return $this->render('news/editNews.html.twig', [
            'form' => $form,
        ]);
    }
















    #[Route('/newsAdd', name: 'add_news')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $article = new News();
        $article->setName('Article 2')
             ->setContent('This is a very nice article but with the number 2!')
             ->setpDate(new \DateTime('2023-08-13'));

        $entityManager->getRepository(News::class)->save($article, true);

        return new Response('Saved new article with id'.$article->getId());
    }

    #[Route('/newsArticle/{id}', name: 'news_article')]
    public function newsArticle(News $news, Comments $comments) : Response 
    {

        $comments = $news->getComments();

        return $this->render('news/showNews.html.twig', [
            'news' => $news,
            'comments' => $comments
        ]);
    }

    #[Route('/removeNews', name: 'remove_news')]
    public function removeNews(EntityManagerInterface $entityManager, $id = 4): Response
    {
        $article = $entityManager->getRepository(News::class)->find($id);

        if ($article) {
        $entityManager->getRepository(News::class)->remove($article, true);
        return new Response('Removed news article with ID '.$article->getId());
        }
        else{
            return new Response('News article not found for ID ' . $id, 404);
        }
        
    }


    #[Route('/editNews', name: 'edit_news')]
    public function changeName(EntityManagerInterface $entityManager, $id = 1): Response
    {

        $news = $entityManager->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException('News article not found for ID ' . $id);
        }
        $newName = 'Article 12';

        $news->setName($newName);

        $entityManager->flush();

        return $this->redirectToRoute('news_list');
    }







}