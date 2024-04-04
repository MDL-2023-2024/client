<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant un atelier.
 */
#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    /**
     * L'identifiant de l'atelier.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le libellé de l'atelier.
     */
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * Le nombre de places maximum de l'atelier.
     */
    #[ORM\Column]
    private ?int $nbPlacesMaxi = null;

    /**
     * Les thèmes de l'atelier.
     */
    #[ORM\ManyToMany(targetEntity: Theme::class, mappedBy: 'ateliers')]
    private Collection $idThemes;

    /**
     * Les inscriptions à l'atelier.
     */
    #[ORM\ManyToMany(targetEntity: Inscription::class, mappedBy: 'ateliers')]
    private ?Collection $inscriptions;

    /**
     * Les vacations de l'atelier.
     */
    #[ORM\OneToMany(targetEntity: Vacation::class, mappedBy: 'atelier')]
    private Collection $vacations;

    /**
     * Crée une nouvelle instance d'atelier.
     */
    public function __construct()
    {
        $this->idThemes = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->vacations = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de l'atelier.
     *
     * @return integer|null L'identifiant de l'atelier.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le libellé de l'atelier.
     *
     * @return string|null Le libellé de l'atelier.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé de l'atelier.
     *
     * @param string $libelle Le libellé de l'atelier.
     * @return static L'instance de l'atelier.
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Retourne le nombre de places maximum de l'atelier.
     *
     * @return integer|null Le nombre de places maximum de l'atelier.
     */
    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    /**
     * Définit le nombre de places maximum de l'atelier.
     *
     * @param integer $nbPlacesMaxi Le nombre de places maximum de l'atelier.
     * @return static L'instance de l'atelier.
     */
    public function setNbPlacesMaxi(int $nbPlacesMaxi): static
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * Retourne les thèmes de l'atelier.
     * 
     * @return Collection<int, Theme>
     */
    public function getIdThemes(): Collection
    {
        return $this->idThemes;
    }

    /**
     * Ajoute un thème à l'atelier.
     * 
     * @param Theme $idTheme Le thème à ajouter.
     * @return static L'instance de l'atelier.
     */
    public function addIdTheme(Theme $idTheme): static
    {
        if (!$this->idThemes->contains($idTheme)) {
            $this->idThemes->add($idTheme);
        }

        return $this;
    }

    /**
     * Supprime un thème de l'atelier.
     * 
     * @param Theme $idTheme Le thème à supprimer.
     * @return static L'instance de l'atelier.
     */
    public function removeIdTheme(Theme $idTheme): static
    {
        $this->idThemes->removeElement($idTheme);

        return $this;
    }

    /**
     * Retourne les inscriptions à l'atelier.
     * 
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    /**
     * Ajoute une inscription à l'atelier.
     * 
     * @param Inscription $inscription L'inscription à ajouter.
     * @return static L'instance de l'atelier.
     */
    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->addAtelier($this);
        }

        return $this;
    }

    /**
     * Supprime une inscription de l'atelier.
     * 
     * @param Inscription $inscription L'inscription à supprimer.
     * @return static L'instance de l'atelier.
     */
    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeAtelier($this);
        }

        return $this;
    }

    /**
     * Retourne les vacations de l'atelier.
     * 
     * @return Collection<int, Vacation>
     */
    public function getVacations(): Collection
    {
        return $this->vacations;
    }

    /**
     * Ajoute une vacation à l'atelier.
     * 
     * @param Vacation $vacation La vacation à ajouter.
     * @return static L'instance de l'atelier.
     */
    public function addVacation(Vacation $vacation): static
    {
        if (!$this->vacations->contains($vacation)) {
            $this->vacations->add($vacation);
            $vacation->setAtelier($this);
        }

        return $this;
    }

    /**
     * Supprime une vacation de l'atelier.
     * 
     * @param Vacation $vacation La vacation à supprimer.
     * @return static L'instance de l'atelier.
     */
    public function removeVacation(Vacation $vacation): static
    {
        if ($this->vacations->removeElement($vacation)) {
            // set the owning side to null (unless already changed)
            if ($vacation->getAtelier() === $this) {
                $vacation->setAtelier(null);
            }
        }

        return $this;
    }

    /**
     * Retourne le libellé de l'atelier.
     *
     * @return string Le libellé de l'atelier.
     */
    public function __toString()
    {
        return $this->libelle;
    }

}
