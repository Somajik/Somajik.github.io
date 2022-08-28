<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\CommandeAEmporterRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CommandeAEmporterRepository::class)
 */
class CommandeAEmporter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $hour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandeAEmporters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reference_commande;

    /**
     * @ORM\OneToMany(targetEntity=CommandeLigne::class, mappedBy="commandeAEmporter")
     */
    private $panier;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getReferenceCommande(): ?User
    {
        return $this->reference_commande;
    }

    public function setReferenceCommande(?User $reference_commande): self
    {
        $this->reference_commande = $reference_commande;

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getPanier(): Collection
    {
        return $this->panier;
    }

    public function addPanier(CommandeLigne $panier): self
    {
        if (!$this->panier->contains($panier)) {
            $this->panier[] = $panier;
            $panier->setCommandeAEmporter($this);
        }

        return $this;
    }

    public function removePanier(CommandeLigne $panier): self
    {
        if ($this->panier->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getCommandeAEmporter() === $this) {
                $panier->setCommandeAEmporter(null);
            }
        }

        return $this;
    }
}
