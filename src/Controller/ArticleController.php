<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;

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

        dd($article);

        return $this->render('article/show.html.twig', [
            'id'   =>  $id
        ]);
    }

    #[Route('/article/add', name: 'article_add')]
    public function add(): Response
    {

        $article = new Article;

        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('article/add.html.twig', [
            'form'   =>  $form
        ]);
    }
}
