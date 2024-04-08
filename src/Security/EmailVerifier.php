<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * Service permettant de gérer la vérification d'email.
 */
class EmailVerifier
{
    /**
     * Crée une nouvelle instance de EmailVerifier.
     *
     * @param VerifyEmailHelperInterface $verifyEmailHelper Le service d'aide à la vérification d'email.
     * @param MailerInterface $mailer Le service d'envoi de mail.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     */
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Envoie un email de confirmation d'email.
     *
     * @param string $verifyEmailRouteName Le nom de la route de vérification d'email.
     * @param UserInterface $user L'utilisateur à qui envoyer l'email.
     * @param TemplatedEmail $email L'email à envoyer.
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail()
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * Gère la confirmation d'email.
     *
     * @param Request $request La requête HTTP.
     * @param UserInterface $user L'utilisateur à qui envoyer l'email.
     * @throws VerifyEmailExceptionInterface En cas d'erreur lors de la validation de l'email.
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
