<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * Controller permettant de gérer l'inscription d'un utilisateur.
 */
class RegistrationController extends AbstractController
{
    /**
     * @var EmailVerifier Le service de vérification d'email.
     */
    private EmailVerifier $emailVerifier;

    /**
     * Crée une nouvelle instance de RegistrationController.
     *
     * @param EmailVerifier $emailVerifier Le service de vérification d'email.
     */
    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * Affiche le formulaire d'inscription et inscrit un utilisateur.
     *
     * @param Request $request La requête HTTP.
     * @param UserPasswordHasherInterface $userPasswordHasher Le service de hachage de mot de passe.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     * @return Response La page d'inscription si erreur ou la page d'accueil si succès.
     */
    #[Route('/register', name: 'app_register')]
    public function register(ApiService $apiService, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Compte();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Fetch user with licencies number doctrine
            $userApi = $apiService->getLicencieBy($form->get('identifiant')->getData());
            if (!$userApi) {
                //flash error message 
                $this->addFlash('error', 'Donnée invalide');
                return $this->redirectToRoute('app_register');
            }
            $userExist = $entityManager->getRepository(Compte::class)->findOneBy(['numlicence' => $userApi['numLicence']]);
            if ($userExist) {
                return $this->redirectToRoute('app_login');
            }

            // Remplissage de l'utilisateur
            $user->setEmail($userApi['mail']);
            $user->setNumlicence($userApi['numLicence']);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@apSio.com', 'Maison Des Ligues'))
                    ->to($user->getEmail())
                    ->subject('Confirmer votre email')
                    ->htmlTemplate('connexion/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Compte créé avec succès, veuillez vérifier votre email pour activer votre compte.');
            return $this->redirectToRoute('acceuil');
        }

        return $this->render('connexion/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Vérifie l'email de l'utilisateur.
     *
     * @param Request $request La requête HTTP.
     * @return Response La page d'inscription si erreur ou la page d'accueil si succès.
     */
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('acceuil');
    }
}
