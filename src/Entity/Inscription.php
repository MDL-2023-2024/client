<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant une inscription.
 */
#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    /**
     * L'identifiant de l'inscription.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * La date d'inscription.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    /**
     * Les ateliers de l'inscription.
     */
    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'inscriptions')]
    private ?Collection $ateliers;

    /**
     * Les restaurations de l'inscription.
     */
    #[ORM\ManyToMany(targetEntity: Restauration::class, inversedBy: 'inscriptions')]
    private ?Collection $restaurations;

    /**
     * Les nuitées de l'inscription.
     */
    #[ORM\OneToMany(targetEntity: Nuite::class, mappedBy: 'inscription')]
    private ?Collection $nuites;

    /**
     * Le compte de l'inscription.
     */
    #[ORM\ManyToOne(inversedBy: 'inscription')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    /**
     * Crée une nouvelle instance d'inscription.
     */
    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->restaurations = new ArrayCollection();
        $this->nuites = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de l'inscription.
     *
     * @return integer|null L'identifiant de l'inscription.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne la date d'inscription.
     *
     * @return \DateTimeInterface|null La date d'inscription.
     */
    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    /**
     * Modifie la date d'inscription.
     *
     * @param \DateTimeInterface $dateInscription La nouvelle date d'inscription.
     * @return Inscription Cette inscription.
     */
    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Retourne les ateliers de l'inscription.
     * 
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    /**
     * Ajoute un atelier à l'inscription.
     * 
     * @param Atelier $atelier L'atelier à ajouter.
     * @return Inscription Cette inscription.
     */
    public function addAtelier(Atelier $atelier): static
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
        }

        return $this;
    }

    /**
     * Supprime un atelier de l'inscription.
     * 
     * @param Atelier $atelier L'atelier à supprimer.
     * @return Inscription Cette inscription.
     */
    public function removeAtelier(Atelier $atelier): static
    {
        $this->ateliers->removeElement($atelier);

        return $this;
    }

    /**
     * Retourne les restaurations de l'inscription.
     * 
     * @return Collection<int, Restauration>
     */
    public function getRestaurations(): Collection
    {
        return $this->restaurations;
    }

    /**
     * Ajoute une restauration à l'inscription.
     * 
     * @param Restauration $restauration La restauration à ajouter.
     * @return Inscription Cette inscription.
     */
    public function addRestauration(Restauration $restauration): static
    {
        if (!$this->restaurations->contains($restauration)) {
            $this->restaurations->add($restauration);
        }

        return $this;
    }

    /**
     * Supprime une restauration de l'inscription.
     * 
     * @param Restauration $restauration La restauration à supprimer.
     * @return Inscription Cette inscription.
     */
    public function removeRestauration(Restauration $restauration): static
    {
        $this->restaurations->removeElement($restauration);

        return $this;
    }

    /**
     * Retourne les nuitées de l'inscription.
     * 
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    /**
     * Ajoute une nuitée à l'inscription.
     * 
     * @param Nuite $nuite La nuitée à ajouter.
     * @return Inscription Cette inscription.
     */
    public function addNuite(Nuite $nuite): static
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setInscription($this);
        }

        return $this;
    }

    /**
     * Supprime une nuitée de l'inscription.
     * 
     * @param Nuite $nuite La nuitée à supprimer.
     * @return Inscription Cette inscription.
     */
    public function removeNuite(Nuite $nuite): static
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getInscription() === $this) {
                $nuite->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * Retourne le compte lié à l'inscription.
     * 
     * @return Compte|null Le compte de l'inscription.
     */
    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    /**
     * Change le compte lié à l'inscription.
     * 
     * @param Compte|null $compte Le nouveau compte de l'inscription.
     * @return Inscription Cette inscription.
     */
    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }
}
