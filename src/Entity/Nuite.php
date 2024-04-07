<?php

namespace App\Entity;

use App\Repository\NuiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant une nuitée.
 */
#[ORM\Entity(repositoryClass: NuiteRepository::class)]
class Nuite
{
    /**
     * L'identifiant de la nuitée.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * La date de la nuitée.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateNuitee = null;

    /**
     * L'inscription de la nuitée.
     */
    #[ORM\ManyToOne(inversedBy: 'nuites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Inscription $inscription = null;

    /**
     * La catégorie de chambre de la nuitée.
     */
    #[ORM\ManyToOne(inversedBy: 'nuites')]
    private ?CategorieChambre $categorie = null;

    /**
     * L'hôtel de la nuitée.
     */
    #[ORM\ManyToOne(inversedBy: 'nuites')]
    private ?Hotel $hotel = null;

    /**
     * Crée une nouvelle instance de nuitée.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne la date de la nuitée.
     *
     * @return \DateTimeInterface|null La date de la nuitée.
     */
    public function getDateNuitee(): ?\DateTimeInterface
    {
        return $this->dateNuitee;
    }

    /**
     * Définit la date de la nuitée.
     *
     * @param \DateTimeInterface $dateNuitee La date de la nuitée.
     *
     * @return static|Nuite Cette nuitée.
     */
    public function setDateNuitee(\DateTimeInterface $dateNuitee): static
    {
        $this->dateNuitee = $dateNuitee;

        return $this;
    }

    /**
     * Retourne l'inscription lié à la nuitée.
     *
     * @return Inscription|null L'inscription lié à la nuitée.
     */
    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    /**
     * Définit l'inscription lié à la nuitée.
     *
     * @param Inscription|null $inscription L'inscription lié à la nuitée.
     *
     * @return static|Nuite Cette nuitée.
     */
    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Retourne la catégorie de chambre de la nuitée.
     *
     * @return CategorieChambre|null La catégorie de chambre de la nuitée.
     */
    public function getCategorie(): ?CategorieChambre
    {
        return $this->categorie;
    }

    /**
     * Définit la catégorie de chambre de la nuitée.
     *
     * @param CategorieChambre|null $categorie La catégorie de chambre de la nuitée.
     *
     * @return static|Nuite Cette nuitée.
     */
    public function setCategorie(?CategorieChambre $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Retourne l'hôtel de la nuitée.
     *
     * @return Hotel|null L'hôtel de la nuitée.
     */
    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    /**
     * Définit l'hôtel de la nuitée.
     *
     * @param Hotel|null $hotel L'hôtel de la nuitée.
     *
     * @return static|Nuite Cette nuitée.
     */
    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }
}
