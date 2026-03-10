<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;

use Doctrine\ORM\EntityManagerInterface;

final class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index')]
    public function index(ArticleRepository $repository): Response
    {


        return $this->render('article/index.html.twig', [
            'articles'   =>  $repository->findAll()
        ]);
    }

    #[Route('/article/{id}-{title}', name: 'article_show')]
    public function show($id, ArticleRepository $repository): Response
    {

        $article = $repository->find($id);

        return $this->render('article/show.html.twig', [
            'article'   =>  $article
        ]);
    }

    #[Route('/article/add', name: 'article_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {

        $article = new Article;

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setAuthor($this->getUser());
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }



        return $this->render('article/add.html.twig', [
            'form'   =>  $form
        ]);
    }
}
