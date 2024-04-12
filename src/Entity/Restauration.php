<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant une restauration.
 */
#[ORM\Entity(repositoryClass: RestaurationRepository::class)]
class Restauration
{
    /**
     * L'identifiant de la restauration.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * La date de la restauration.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRestauration = null;

    /**
     * Le type de repas de la restauration.
     */
    #[ORM\Column(length: 255)]
    private ?string $typeRepas = null;

    /**
     * Les inscriptions de la restauration.
     */
    #[ORM\ManyToMany(targetEntity: Inscription::class, mappedBy: 'restaurations')]
    private Collection $inscriptions;

    /**
     * Crée une nouvelle instance de restauration.
     */
    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de la restauration.
     *
     * @return integer|null L'identifiant de la restauration.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne la date de la restauration.
     *
     * @return \DateTimeInterface|null La date de la restauration.
     */
    public function getDateRestauration(): ?\DateTimeInterface
    {
        return $this->dateRestauration;
    }

    /**
     * Définit la date de la restauration.
     *
     * @param \DateTimeInterface $dateRestauration La date de la restauration.
     *
     * @return static L'instance de la restauration.
     */
    public function setDateRestauration(\DateTimeInterface $dateRestauration): static
    {
        $this->dateRestauration = $dateRestauration;

        return $this;
    }

    /**
     * Retourne le type de repas de la restauration.
     *
     * @return string|null Le type de repas de la restauration.
     */
    public function getTypeRepas(): ?string
    {
        return $this->typeRepas;
    }

    /**
     * Définit le type de repas de la restauration.
     *
     * @param string $typeRepas Le type de repas de la restauration.
     *
     * @return static L'instance de la restauration.
     */
    public function setTypeRepas(string $typeRepas): static
    {
        $this->typeRepas = $typeRepas;

        return $this;
    }

    /**
     * Retourne les inscriptions de la restauration.
     * 
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    /**
     * Ajoute une inscription à la restauration.
     * 
     * @param Inscription $inscription L'inscription à ajouter.
     * @return Restauration Cette restauration.
     */
    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->addRestauration($this);
        }

        return $this;
    }

    /**
     * Supprime une inscription de la restauration.
     * 
     * @param Inscription $inscription L'inscription à supprimer.
     * @return Restauration Cette restauration.
     */
    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeRestauration($this);
        }

        return $this;
    }

    /**
     * Retourne une représentation textuelle de la restauration.
     *
     * @return string Une représentation textuelle de la restauration.
     */
    public function __toString(): string
    {
        return "{$this->typeRepas} du {$this->dateRestauration->format('d/m/Y')}";
    }
}
