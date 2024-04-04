<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité représentant un hôtel.
 */
#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    /**
     * L'identifiant de l'hôtel.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Le nom de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $pnom = null;

    /**
     * La première adresse de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $adresse1 = null;

    /**
     * La deuxième adresse de l'hôtel.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse2 = null;

    /**
     * Le code postal de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $cp = null;

    /**
     * La ville de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    /**
     * Le numéro de téléphone de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    /**
     * L'adresse email de l'hôtel.
     */
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    /**
     * Les nuitées de l'hôtel.
     */
    #[ORM\OneToMany(targetEntity: Nuite::class, mappedBy: 'hotel')]
    private Collection $nuites;

    /**
     * Les tarifs de l'hôtel.
     */
    #[ORM\OneToMany(targetEntity: Proposer::class, mappedBy: 'hotel')]
    private Collection $tarifs;

    /**
     * Le site web de l'hôtel.
     */
    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $website = null;

    /**
     * Crée une nouvelle instance d'hôtel.
     */
    public function __construct()
    {
        $this->nuites = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant de l'hôtel.
     *
     * @return integer|null L'identifiant de l'hôtel.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom de l'hôtel.
     *
     * @return string|null Le nom de l'hôtel.
     */
    public function getPnom(): ?string
    {
        return $this->pnom;
    }

    /**
     * Modifie le nom de l'hôtel.
     *
     * @param string $pnom Le nouveau nom de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setPnom(string $pnom): static
    {
        $this->pnom = $pnom;

        return $this;
    }

    /**
     * Retourne la première adresse de l'hôtel.
     *
     * @return string|null La première adresse de l'hôtel.
     */
    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    /**
     * Modifie la première adresse de l'hôtel.
     *
     * @param string $adresse1 La nouvelle première adresse de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setAdresse1(string $adresse1): static
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Retourne la deuxième adresse de l'hôtel.
     *
     * @return string|null La deuxième adresse de l'hôtel.
     */
    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    /**
     * Modifie la deuxième adresse de l'hôtel.
     *
     * @param string|null $adresse2 La nouvelle deuxième adresse de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setAdresse2(?string $adresse2): static
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Retourne le code postal de l'hôtel.
     *
     * @return string|null Le code postal de l'hôtel.
     */
    public function getCp(): ?string
    {
        return $this->cp;
    }

    /**
     * Modifie le code postal de l'hôtel.
     *
     * @param string $cp Le nouveau code postal de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Retourne la ville de l'hôtel.
     *
     * @return string|null La ville de l'hôtel.
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * Modifie la ville de l'hôtel.
     *
     * @param string $ville La nouvelle ville de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Retourne le numéro de téléphone de l'hôtel.
     *
     * @return string|null Le numéro de téléphone de l'hôtel.
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * Modifie le numéro de téléphone de l'hôtel.
     *
     * @param string $tel Le nouveau numéro de téléphone de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Retourne l'adresse email de l'hôtel.
     *
     * @return string|null L'adresse email de l'hôtel.
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Modifie l'adresse email de l'hôtel.
     *
     * @param string $mail La nouvelle adresse email de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Retourne les nuitées de l'hôtel.
     * 
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    /**
     * Ajoute une nuitée à l'hôtel.
     * 
     * @param Nuite $nuite La nuitée à ajouter.
     * @return Hotel Cet hôtel.
     */
    public function addNuite(Nuite $nuite): static
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setHotel($this);
        }

        return $this;
    }

    /**
     * Supprime une nuitée de l'hôtel.
     * 
     * @param Nuite $nuite La nuitée à supprimer.
     * @return Hotel Cet hôtel.
     */
    public function removeNuite(Nuite $nuite): static
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getHotel() === $this) {
                $nuite->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * Retourne les tarifs de l'hôtel.
     * 
     * @return Collection<int, Proposer>
     */
    public function getProposers(): Collection
    {
        return $this->tarifs;
    }

    /**
     * Ajoute un tarif à l'hôtel.
     * 
     * @param Proposer $proposer Le tarif à ajouter.
     * @return Hotel Cet hôtel.
     */
    public function addProposer(Proposer $proposer): static
    {
        if (!$this->tarifs->contains($proposer)) {
            $this->tarifs->add($proposer);
            $proposer->setHotel($this);
        }

        return $this;
    }

    /**
     * Supprime un tarif de l'hôtel.
     * 
     * @param Proposer $proposer Le tarif à supprimer.
     * @return Hotel Cet hôtel.
     */
    public function removeProposer(Proposer $proposer): static
    {
        if ($this->tarifs->removeElement($proposer)) {
            // set the owning side to null (unless already changed)
            if ($proposer->getHotel() === $this) {
                $proposer->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * Retourne le lien site web de l'hôtel.
     *
     * @return string|null Le site web de l'hôtel.
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * Modifie le lien du site web de l'hôtel.
     *
     * @param string|null $website Le nouveau site web de l'hôtel.
     * @return Hotel Cet hôtel.
     */
    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }
}
