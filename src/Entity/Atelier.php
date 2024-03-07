<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $nbPlacesMaxi = null;

    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'ateliers')]
    private Collection $idThemes;

    public function __construct()
    {
        $this->idThemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    public function setNbPlacesMaxi(int $nbPlacesMaxi): static
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getIdThemes(): Collection
    {
        return $this->idThemes;
    }

    public function addIdTheme(Theme $idTheme): static
    {
        if (!$this->idThemes->contains($idTheme)) {
            $this->idThemes->add($idTheme);
        }

        return $this;
    }

    public function removeIdTheme(Theme $idTheme): static
    {
        $this->idThemes->removeElement($idTheme);

        return $this;
    }
}
