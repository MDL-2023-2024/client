<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

/**
 * Entité représentant une demande de réinitialisation de mot de passe.
 */
#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

    /**
     * L'identifiant de la demande de réinitialisation de mot de passe.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * L'utilisateur ayant demandé la réinitialisation de mot de passe.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $user = null;

    /**
     * Crée une nouvelle instance de demande de réinitialisation de mot de passe.
     *
     * @param object $user L'utilisateur ayant demandé la réinitialisation de mot de passe.
     * @param \DateTimeInterface $expiresAt La date d'expiration de la demande.
     * @param string $selector Le sélecteur de la demande.
     * @param string $hashedToken Le jeton de la demande.
     */
    public function __construct(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    /**
     * Retourne l'identifiant de la demande de réinitialisation de mot de passe.
     *
     * @return integer|null L'identifiant de la demande de réinitialisation de mot de passe.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'utilisateur ayant demandé la réinitialisation de mot de passe.
     *
     * @return object L'utilisateur ayant demandé la réinitialisation de mot de passe.
     */
    public function getUser(): object
    {
        return $this->user;
    }
}
