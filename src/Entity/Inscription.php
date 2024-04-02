<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'inscriptions')]
    private ?Collection $ateliers;

    #[ORM\ManyToMany(targetEntity: Restauration::class, inversedBy: 'inscriptions')]
    private ?Collection $restaurations;

    #[ORM\OneToMany(targetEntity: Nuite::class, mappedBy: 'inscription')]
    private ?Collection $nuites;

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->restaurations = new ArrayCollection();
        $this->nuites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): static
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): static
    {
        $this->ateliers->removeElement($atelier);

        return $this;
    }

    /**
     * @return Collection<int, Restauration>
     */
    public function getRestaurations(): Collection
    {
        return $this->restaurations;
    }

    public function addRestauration(Restauration $restauration): static
    {
        if (!$this->restaurations->contains($restauration)) {
            $this->restaurations->add($restauration);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): static
    {
        $this->restaurations->removeElement($restauration);

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
            $nuite->setInscription($this);
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): static
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getInscription() === $this) {
                $nuite->setInscription(null);
            }
        }

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }
}
