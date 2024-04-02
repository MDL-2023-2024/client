<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request): Response
    {
        // Créer une nouvelle inscription
        $inscription = new Inscription();

        // Créer le formulaire
        $form = $this->createForm(InscriptionType::class, $inscription);

        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, vous pouvez sauvegarder l'inscription dans la base de données
            // par exemple, en utilisant l'EntityManager
            

            // Rediriger l'utilisateur ou afficher un message de succès
            return $this->redirectToRoute('acceuil');
        }

        // Rendre le formulaire dans la vue
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
