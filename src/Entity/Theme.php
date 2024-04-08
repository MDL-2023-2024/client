<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant un thème.
 */
#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    /**
     * L'identifiant du thème.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le libellé du thème.
     */
    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * Les ateliers du thème.
     */
    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'idThemes')]
    private Collection $ateliers;

    /**
     * Crée une nouvelle instance de thème.
     */
    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant du thème.
     *
     * @return integer|null L'identifiant du thème.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le libellé du thème.
     *
     * @return string|null Le libellé du thème.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé du thème.
     *
     * @param string $libelle Le libellé du thème.
     *
     * @return Theme Cette instance.
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Retourne les ateliers du thème.
     * 
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    /**
     * Ajoute un atelier au thème.
     *
     * @param Atelier $atelier L'atelier à ajouter.
     *
     * @return Theme Ce thème.
     */
    public function addAtelier(Atelier $atelier): static
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
            $atelier->addIdTheme($this);
        }

        return $this;
    }

    /**
     * Supprime un atelier du thème.
     *
     * @param Atelier $atelier L'atelier à supprimer.
     *
     * @return Theme Ce thème.
     */
    public function removeAtelier(Atelier $atelier): static
    {
        if ($this->ateliers->removeElement($atelier)) {
            $atelier->removeIdTheme($this);
        }

        return $this;
    }

    /**
     * Retourne une représentation textuelle du thème.
     */
    public function __toString()
    {
        return $this->getLibelle();
    }
}
