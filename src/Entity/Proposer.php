<?php

namespace App\Entity;

use App\Repository\ProposerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProposerRepository::class)]
class Proposer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $tarifNuite = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?Hotel $hotel = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?CategorieChambre $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifNuite(): ?float
    {
        return $this->tarifNuite;
    }

    public function setTarifNuite(float $tarifNuite): static
    {
        $this->tarifNuite = $tarifNuite;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getCategorie(): ?CategorieChambre
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieChambre $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
