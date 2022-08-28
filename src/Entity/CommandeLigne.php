<?php

namespace App\Entity;

use App\Repository\CommandeLigneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeLigneRepository::class)
 */
class CommandeLigne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Plat::class, inversedBy="reference_commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plat;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeAEmporter::class, inversedBy="panier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandeAEmporter;

    /**
     * @ORM\ManyToMany(targetEntity=Plat::class, inversedBy="commandeLignes")
     */
    private $quantity_number;

    public function __construct()
    {
        $this->quantity_number = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): self
    {
        $this->plat = $plat;

        return $this;
    }

    public function getCommandeAEmporter(): ?CommandeAEmporter
    {
        return $this->commandeAEmporter;
    }

    public function setCommandeAEmporter(?CommandeAEmporter $commandeAEmporter): self
    {
        $this->commandeAEmporter = $commandeAEmporter;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getQuantityNumber(): Collection
    {
        return $this->quantity_number;
    }

    public function addQuantityNumber(Plat $quantityNumber): self
    {
        if (!$this->quantity_number->contains($quantityNumber)) {
            $this->quantity_number[] = $quantityNumber;
        }

        return $this;
    }

    public function removeQuantityNumber(Plat $quantityNumber): self
    {
        $this->quantity_number->removeElement($quantityNumber);

        return $this;
    }
}
