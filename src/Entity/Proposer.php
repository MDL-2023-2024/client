<?php

namespace App\Entity;

use App\Repository\ProposerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant un tarif proposé par un hôtel pour une catégorie de chambre.
 */
#[ORM\Entity(repositoryClass: ProposerRepository::class)]
class Proposer
{
    /**
     * L'identifiant du tarif.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le tarif de la nuitée.
     */
    #[ORM\Column(nullable: true)]
    private ?float $tarifNuite = null;

    /**
     * L'hôtel proposant le tarif.
     */
    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?Hotel $hotel = null;

    /**
     * La catégorie de chambre concernée par le tarif.
     */
    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?CategorieChambre $categorie = null;

    /**
     * Retourne l'identifiant du tarif.
     *
     * @return integer|null L'identifiant du tarif.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le tarif de la nuitée.
     *
     * @return float|null Le tarif de la nuitée.
     */
    public function getTarifNuite(): ?float
    {
        return $this->tarifNuite;
    }

    /**
     * Définit le tarif de la nuitée.
     *
     * @param float $tarifNuite Le tarif de la nuitée.
     *
     * @return static L'instance de l'entité.
     */
    public function setTarifNuite(float $tarifNuite): static
    {
        $this->tarifNuite = $tarifNuite;

        return $this;
    }

    /**
     * Retourne l'hôtel proposant le tarif.
     *
     * @return Hotel|null L'hôtel proposant le tarif.
     */
    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    /**
     * Définit l'hôtel proposant le tarif.
     *
     * @param Hotel|null $hotel L'hôtel proposant le tarif.
     *
     * @return static L'instance de l'entité.
     */
    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Retourne la catégorie de chambre concernée par le tarif.
     *
     * @return CategorieChambre|null La catégorie de chambre concernée par le tarif.
     */
    public function getCategorie(): ?CategorieChambre
    {
        return $this->categorie;
    }

    /**
     * Définit la catégorie de chambre concernée par le tarif.
     *
     * @param CategorieChambre|null $categorie La catégorie de chambre concernée par le tarif.
     *
     * @return static L'instance de l'entité.
     */
    public function setCategorie(?CategorieChambre $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
