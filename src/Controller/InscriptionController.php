<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Nuite;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionController extends AbstractController {

    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, ManagerRegistry $doctrine): Response {

        $entityManager = $doctrine->getManager();
        // Créer une nouvelle inscription
        $inscription = new Inscription();
        $inscription->setDateInscription(new \DateTime());
        $nuite1 = new Nuite();
        $nuite1->setDateNuitee(new \DateTime('2021-10-01'));
        $nuite2 = new Nuite();
        $inscription->getNuites()->add($nuite1);
        $inscription->getNuites()->add($nuite2);

        // Créer le formulaire
        $form = $this->createForm(InscriptionType::class, $inscription);
        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, vous pouvez sauvegarder l'inscription dans la base de données
            // par exemple, en utilisant l'EntityManager
            $inscription->setCompte($this->getUser());
            $entityManager->persist($inscription);
            $nuite1->setInscription($inscription);
            $entityManager->persist($nuite1);
            $nuite2->setInscription($inscription);
            $entityManager->persist($nuite2);
            $entityManager->flush();
            $this->addFlash('success', 'Inscription creé avec succès !');

            // Rediriger l'utilisateur ou afficher un message de succès
//            return $this->redirectToRoute('');
        }

        $email = $this->getUser()->getUserIdentifier();
        $numLicence = $this->getUser()->getNumlicence();

        // Rendre le formulaire dans la vue
        return $this->render('inscription/index.html.twig', [
                    'form' => $form->createView(), 
                    'numLicence' => $numLicence, 
                    'email' => $email,
        ]);
    }
}
