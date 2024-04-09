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

class InscriptionController extends AbstractController
{

    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response {
        $entityManager = $doctrine->getManager();

        // Créer une nouvelle inscription
        $inscription = new Inscription();
        $nuite1 = new Nuite();
        $nuite2 = new Nuite();
        $nuite1->setDateNuitee(new \DateTime('2024-09-07'));
        $nuite2->setDateNuitee(new \DateTime('2024-09-08'));
        $inscription->getNuites()->add($nuite1);
        $inscription->getNuites()->add($nuite2);

        // Créer le formulaire
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription->setDateInscription(new \DateTime());
            // Ici, vous pouvez sauvegarder l'inscription dans la base de données
            // par exemple, en utilisant l'EntityManager
            $inscription->setCompte($this->getUser());
            $entityManager->persist($inscription);
            $nuite1->setInscription($inscription);
            $entityManager->persist($nuite1);
            $nuite2->setInscription($inscription);
            $entityManager->persist($nuite2);
            $entityManager->flush();
            $mail=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
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

            // Rediriger l'utilisateur ou afficher un message de succès
            return $this->redirectToRoute('inscription_confirm', ['inscription' => $inscription]);
        }

        // Affichage du formulaire
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'numLicence' => $this->getUser()->getNumLicence(),
            'email' => $this->getUser()->getEmail(),
        ]);
    }

    #[Route('/inscription/confirm', name: 'inscription_confirm')]
    public function confirm(Request $request): Response
    {
        $inscription = $request->get('inscription');
        $total = 130;
        foreach ($inscription->getNuites() as $nuite) {
            $total += $nuite->getCategorie()->getTarifs()[0]->getTarifNuite();
        }
        foreach ($inscription->getRestaurations() as $restauration) {
            $total += 38;
        }
        // Afficher un message de confirmation
        return $this->render('inscription/confirm.html.twig', [
            'total' => $total,
            'inscription' => $inscription,
        ]);
    }
}
