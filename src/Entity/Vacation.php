<?php

namespace App\Entity;

use App\Repository\VacationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant une vacation.
 */
#[ORM\Entity(repositoryClass: VacationRepository::class)]
class Vacation
{
    /**
     * L'identifiant de la vacation.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * La date et l'heure de début de la vacation.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateheureDebut = null;

    /**
     * La date et l'heure de fin de la vacation.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan(propertyPath: 'dateheureDebut')]
    private ?\DateTimeInterface $dateheureFin = null;

    /**
     * L'atelier de la vacation.
     */
    #[ORM\ManyToOne(inversedBy: 'vacations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Atelier $atelier = null;

    /**
     * Crée une nouvelle instance de vacation.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne la date et l'heure de début de la vacation.
     *
     * @return \DateTimeInterface|null La date et l'heure de début de la vacation.
     */
    public function getDateheureDebut(): ?\DateTimeInterface
    {
        return $this->dateheureDebut;
    }

    /**
     * Définit la date et l'heure de début de la vacation.
     *
     * @param \DateTimeInterface $dateheureDebut La date et l'heure de début de la vacation.
     *
     * @return static L'instance de l'entité.
     */
    public function setDateheureDebut(\DateTimeInterface $dateheureDebut): static
    {
        $this->dateheureDebut = $dateheureDebut;

        return $this;
    }

    /**
     * Retourne la date et l'heure de fin de la vacation.
     *
     * @return \DateTimeInterface|null La date et l'heure de fin de la vacation.
     */
    public function getDateheureFin(): ?\DateTimeInterface
    {
        return $this->dateheureFin;
    }

    /**
     * Définit la date et l'heure de fin de la vacation.
     *
     * @param \DateTimeInterface $dateheureFin La date et l'heure de fin de la vacation.
     *
     * @return static L'instance de l'entité.
     */
    public function setDateheureFin(\DateTimeInterface $dateheureFin): static
    {
        $this->dateheureFin = $dateheureFin;

        return $this;
    }

    /**
     * Retourne l'atelier de la vacation.
     *
     * @return Atelier|null L'atelier de la vacation.
     */
    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    /**
     * Définit l'atelier de la vacation.
     *
     * @param Atelier|null $atelier L'atelier de la vacation.
     *
     * @return static L'instance de l'entité.
     */
    public function setAtelier(?Atelier $atelier): static
    {
        $this->atelier = $atelier;

        return $this;
    }

}
