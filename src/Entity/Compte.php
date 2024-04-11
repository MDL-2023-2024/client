<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Entité représentant un compte utilisateur.
 */
#[ORM\Entity(repositoryClass: CompteRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Compte implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * L'identifiant du compte.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * L'email du compte.
     */
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * Les rôles du compte.
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string Le mot de passe haché du compte.
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * Le numéro de licence du compte.
     */
    #[ORM\Column(length: 255, unique: true)]
    private ?string $numlicence = null;

    /**
     * Les inscriptions du compte a des ateliers.
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'compte')]
    private Collection $inscription;

    /**
     * Indique si le compte a son email vérifié.
     */
    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /**
     * Crée une nouvelle instance de compte.
     */
    public function __construct()
    {
        $this->inscription = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant du compte.
     *
     * @return integer|null L'identifiant du compte.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'email du compte.
     *
     * @return string|null L'email du compte.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Modifie l'email du compte.
     *
     * @param string $email Le nouvel email du compte.
     * @return Compte Ce compte.
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     * @return string L'email du compte.
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Retourne les rôles du compte.
     * 
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_INSCRIT';

        return array_unique($roles);
    }

    /**
     * Modifie les rôles du compte.
     * 
     * @param array $roles Les nouveaux rôles du compte.
     * @return Compte Ce compte.
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Retourne le mot de passe du compte.
     * 
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Modifie le mot de passe du compte.
     * 
     * @param string $password Le nouveau mot de passe du compte.
     * @return Compte Ce compte.
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Retourne le numéro de licence du compte.
     * 
     * @return string|null Le numéro de licence du compte.
     */
    public function getNumlicence(): ?string
    {
        return $this->numlicence;
    }

    /**
     * Modifie le numéro de licence du compte.
     * 
     * @param string $numlicence Le nouveau numéro de licence du compte.
     * @return Compte Ce compte.
     */
    public function setNumlicence(string $numlicence): static
    {
        $this->numlicence = $numlicence;

        return $this;
    }

    /**
     * Retourne les inscriptions du compte.
     * 
     * @return Collection<int, Inscription>
     */
    public function getInscription(): Collection
    {
        return $this->inscription;
    }

    /**
     * Ajoute une inscription au compte.
     * 
     * @param Inscription $inscription L'inscription à ajouter.
     * @return Compte Ce compte.
     */
    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription->add($inscription);
            $inscription->setCompte($this);
        }

        return $this;
    }

    /**
     * Supprime une inscription du compte.
     * 
     * @param Inscription $inscription L'inscription à supprimer.
     * @return Compte Ce compte.
     */
    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscription->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getCompte() === $this) {
                $inscription->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * Retourne si le compte est vérifié.
     * 
     * @return bool Vrai si le compte est vérifié, faux sinon.
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * Modifie si le compte est vérifié.
     * 
     * @param bool $isVerified Vrai si le compte est vérifié, faux sinon.
     * @return Compte Ce compte.
     */
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    
            public function __toString(){
        return $this->getEmail();
    }

    /**
     * Retourne le nom du licencié.
     * 
     * @return string Le nom du licencié.
     */
    public function getNom(): string
    {
        return (new \App\Service\ApiService)->getNomById($this->numlicence);
    }

    /**
     * Retourne le prénom du licencié.
     * 
     * @return string Le prénom du licencié.
     */
    public function getPrenom(): string
    {
        return (new \App\Service\ApiService)->getPrenomById($this->numlicence);
    }
}
