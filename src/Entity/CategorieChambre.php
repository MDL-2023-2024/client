<?php

namespace App\Entity;

use App\Repository\CategorieChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieChambreRepository::class)]
class CategorieChambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleCategorie = null;

    #[ORM\OneToMany(targetEntity: Nuite::class, mappedBy: 'categorie')]
    private ?Collection $nuites;

    #[ORM\OneToMany(targetEntity: Proposer::class, mappedBy: 'categorie')]
    private Collection $tarifs;

    public function __construct()
    {
        $this->nuites = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelleCategorie;
    }

    public function setLibelleCategorie(string $libelleCategorie): static
    {
        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    public function addNuite(Nuite $nuite): static
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setCategorie($this);
        }

        return $this;
    }

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
     * @return Collection<int, Proposer>
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Proposer $tarif): static
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs->add($tarif);
            $tarif->setCategorie($this);
        }

        return $this;
    }

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
