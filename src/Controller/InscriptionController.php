<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Nuite;
use App\Entity\Proposer;
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\isNull;

#[IsGranted("ROLE_INSCRIT")]
class InscriptionController extends AbstractController {

    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, ManagerRegistry $doctrine): Response {

        // Créer une nouvelle inscription
        $inscription = new Inscription();
        $nuite1 = new Nuite();
        $nuite2 = new Nuite();
        $nuite1->setDateNuitee(new \DateTime('2024-09-07'));
        $nuite2->setDateNuitee(new \DateTime('2024-09-08'));
        $inscription->getNuites()->add($nuite1);
        $inscription->getNuites()->add($nuite2);

        // Créer le formulaire
        $form = $this->createForm(InscriptionType::class, $inscription, [
            'action' => $this->generateUrl('inscription_confirm'),
        ]);
        $form->handleRequest($request);
        $form->get('email')->setData($this->getUser()->getEmail());
        return $this->render('inscription/index.html.twig', [
                    'form' => $form->createView(),
                    'numLicence' => $this->getUser()->getNumLicence(),
        ]);
    }

    #[Route('/inscription/confirm', name: 'inscription_confirm')]
    public function confirm(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response {
        $total = 130;
        $entityManager = $doctrine->getManager();

        // Créer une nouvelle inscription
        $inscription = new Inscription();
        $nuite1 = new Nuite();
        $nuite2 = new Nuite();
        $inscription->getNuites()->add($nuite1);
        $inscription->getNuites()->add($nuite2);

        $form = $this->createForm(InscriptionType::class, $inscription, [
            'action' => $this->generateUrl('inscription_confirm'),
        ]);
        $form->handleRequest($request);
        $email = $request->get('email');

        if ($form->isSubmitted() && $form->isValid()) {
            $tarifs = $doctrine->getRepository(Proposer::class)->findAll();
            foreach ($inscription->getNuites() as $nuite) {
                $proposer = $doctrine->getRepository(Proposer::class)->findByHotelAndCategorie($nuite->getHotel(), $nuite->getCategorie());
                $total += ($proposer == null) ? 0 : $proposer->getTarifNuite();
            }
            foreach ($inscription->getRestaurations() as $restauration) {
                $total += 38;
            }

            if ($request->get('confirm') == 'true') {
                $inscription->setDateInscription(new \DateTime());
                $inscription->setCompte($this->getUser());
                $entityManager->persist($inscription);
                $nuite1->setInscription($inscription);
                $entityManager->persist($nuite1);
                $nuite2->setInscription($inscription);
                $entityManager->persist($nuite2);

                $email = (new TemplatedEmail())
                        ->from(new Address('no-reply@apsio.com', 'Confirmation Inscription | Maison Des Ligues'))
                        ->to($email)
                        ->subject('Confirmation de votre inscription')
                        ->htmlTemplate('inscription/confirmation_email.html.twig')
                        ->context([
                    'user' => $this->getUser(),
                    'inscription' => $inscription,
                ]);

                $mailer->send($email);

                $this->addFlash('success', 'Inscription confirmée et e-mail envoyé avec succès.');

                // Redirection vers la page de confirmation
                return $this->redirectToRoute('acceuil');
            }
        }

        // Affichage de la page de confirmation
        return $this->render('inscription/confirm.html.twig', [
                    'form' => $form->createView(),
                    'inscription' => $inscription,
                    'email' => $email,
                    'tarifs' => $tarifs,
                    'total' => $total,
                        // autres variables nécessaires pour la vue
        ]);
    }
}
