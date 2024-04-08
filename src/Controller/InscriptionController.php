<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Nuite;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionController extends AbstractController {

    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response {
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription->setCompte($this->getUser()); // Assuming $this->getUser() returns the currently logged in user
            $entityManager->persist($inscription);
            $entityManager->persist($nuite1);
            $entityManager->persist($nuite2);
            $entityManager->flush();
            $mail=filer_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $this->addFlash('success', 'Inscription créée avec succès !');

            // Préparation de l'email
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@apsio.com', 'Confirmation Inscription | Maison Des Ligues'))
                ->to($mail)
                ->subject('Confirmation de votre inscription')
                ->htmlTemplate('inscription/confirmation.html.twig')
                ->context([
                    'user' => $this->getUser(),
                    'inscription' => $inscription,
                ]);

            // Envoi de l'email
            $mailer->send($email);

            // Redirection après l'inscription et l'envoi de l'email
            return $this->redirectToRoute('acceuil');
        }

        // Affichage du formulaire
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'numLicence' => $this->getUser()->getNumLicence(),
            'email' => $this->getUser()->getEmail(),
        ]);
    }
}
