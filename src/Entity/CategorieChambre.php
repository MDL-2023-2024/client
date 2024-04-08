<?php

namespace App\Entity;

use App\Repository\CategorieChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant une catégorie de chambre.
 */
#[ORM\Entity(repositoryClass: CategorieChambreRepository::class)]
class CategorieChambre
{
    /**
     * L'identifiant de la catégorie de chambre.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le libellé de la catégorie de chambre.
     */
    #[ORM\Column(length: 255)]
    private ?string $libelleCategorie = null;

    /**
     * Les nuitées de la catégorie de chambre.
     */
    #[ORM\OneToMany(targetEntity: Nuite::class, mappedBy: 'categorie')]
    private ?Collection $nuites;

    /**
     * Les tarifs de la catégorie de chambre.
     */
    #[ORM\OneToMany(targetEntity: Proposer::class, mappedBy: 'categorie')]
    private Collection $tarifs;

    /**
     * Crée une nouvelle instance de catégorie de chambre.
     */
    public function __construct()
    {
        $this->nuites = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de la catégorie de chambre.
     *
     * @return integer|null L'identifiant de la catégorie de chambre.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le libellé de la catégorie de chambre.
     *
     * @return string|null Le libellé de la catégorie de chambre.
     */
    public function getLibelleCategorie(): ?string
    {
        return $this->libelleCategorie;
    }

    /**
     * Modifie le libellé de la catégorie de chambre.
     *
     * @param string $libelleCategorie Le nouveau libellé de la catégorie de chambre.
     * @return CategorieChambre Cette catégorie de chambre.
     */
    public function setLibelleCategorie(string $libelleCategorie): static
    {
        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }

    /**
     * Retourne les nuitées de la catégorie de chambre.
     * 
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    /**
     * Ajoute une nuitée à la catégorie de chambre.
     * 
     * @param Nuite $nuite La nuitée à ajouter.
     * @return CategorieChambre Cette catégorie de chambre.
     */
    public function addNuite(Nuite $nuite): static
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setCategorie($this);
        }

        return $this;
    }

    /**
     * Supprime une nuitée de la catégorie de chambre.
     * 
     * @param Nuite $nuite La nuitée à supprimer.
     * @return CategorieChambre Cette catégorie de chambre.
     */
    public function removeNuite(Nuite $nuite): static
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getCategorie() === $this) {
                $nuite->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * Retourne les tarifs de la catégorie de chambre.
     * 
     * @return Collection<int, Proposer>
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    /**
     * Ajoute un tarif à la catégorie de chambre.
     * 
     * @param Proposer $tarif Le tarif à ajouter.
     * @return CategorieChambre Cette catégorie de chambre.
     */
    public function addTarif(Proposer $tarif): static
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs->add($tarif);
            $tarif->setCategorie($this);
        }

        return $this;
    }

    /**
     * Supprime un tarif de la catégorie de chambre.
     * 
     * @param Proposer $tarif Le tarif à supprimer.
     * @return CategorieChambre Cette catégorie de chambre.
     */
    public function removeTarif(Proposer $tarif): static
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getCategorie() === $this) {
                $tarif->setCategorie(null);
            }
        }

        return $this;
    }
}
