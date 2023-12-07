<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    
      #Route('/article/new', name='new_article')
   
    public function newArticle(Request $request): Response
    {
        // Vérifier si l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Créer une nouvelle instance d'article
        $article = new Article();

        // Récupérer l'utilisateur actuel et l'associer à l'article
        $user = $this->getUser();
        $article->setUser($user);

        // Créer un formulaire pour la publication d'articles
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'ajout d'une image (à adapter selon votre besoin)

            // Sauvegarder l'article en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une page de confirmation
            return $this->redirectToRoute('article_confirmation');
        }

        // Afficher le formulaire dans la vue
        return $this->render('article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
