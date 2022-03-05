<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article')]
class ArticleController extends AbstractController
{

    /**
     * test pour utiliser une méthode customisée du repository
     *
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    #[Route('/debug_test', name: 'debug_test')]
    public function test(ArticleRepository $articleRepository) : JsonResponse
    {
        $result = $articleRepository->getCommentaire(14);

        return new JsonResponse($result);
    }

    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    
    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST']), IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article);
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Article $article, ManagerRegistry $doctrine, $id): Response
    {

        $commentaire = new Commentaire;

        $commentaire_form = $this->createForm(CommentaireType::class, $commentaire);
        $commentaire_form->add('submit', SubmitType::class);
        $commentaire_form->handleRequest($request);

        

        //quand le formulaire est soumis
        if ($commentaire_form->isSubmitted() && $commentaire_form->isValid()) {

            $commentaire->setDateCreation(new \DateTime());
            $commentaire->setArticle($article);
            $commentaire->setAuteur($this->getUser());
            $commentaire->setValidation(false);

            $manager = $doctrine->getManager();
            $manager->persist($commentaire);
            $manager->flush();

            return $this->redirectToRoute('app_article_show', ['id' => $id]);

        }

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentaire_form' => $commentaire_form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST']), IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article);
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST']), IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }


}
