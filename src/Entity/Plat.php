<?php

namespace App\Entity;

use App\Entity\Formule;
use App\Entity\Category;
use App\Entity\PlatJour;
use App\Entity\CommandeLigne;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlatRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 */
class Plat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text", length=55)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Formule::class, inversedBy="plats")
     * @ORM\JoinColumn(nullable=true)
     */
    private $formule_number;

    /**
     * @ORM\ManyToOne(targetEntity=PlatJour::class, inversedBy="plats")
     */
    private $plat_jour_number;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="plats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_number;

    /**
     * @ORM\OneToMany(targetEntity=CommandeLigne::class, mappedBy="plat")
     */
    private $reference_commande;

    /**
     * @ORM\ManyToMany(targetEntity=CommandeLigne::class, mappedBy="quantity_number")
     */
    private $commandeLignes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $a_emporter;

    public function __construct()
    {
        $this->reference_commande = new ArrayCollection();
        $this->commandeLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getFormuleNumber(): ?Formule
    {
        return $this->formule_number;
    }

    public function setFormuleNumber(?Formule $formule_number): self
    {
        $this->formule_number = $formule_number;

        return $this;
    }

    public function getPlatJourNumber(): ?PlatJour
    {
        return $this->plat_jour_number;
    }

    public function setPlatJourNumber(?PlatJour $plat_jour_number): self
    {
        $this->plat_jour_number = $plat_jour_number;

        return $this;
    }

    public function getCategoryNumber(): ?Category
    {
        return $this->category_number;
    }

    public function setCategoryNumber(?Category $category_number): self
    {
        $this->category_number = $category_number;

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getReferenceCommande(): Collection
    {
        return $this->reference_commande;
    }

    public function addReferenceCommande(CommandeLigne $referenceCommande): self
    {
        if (!$this->reference_commande->contains($referenceCommande)) {
            $this->reference_commande[] = $referenceCommande;
            $referenceCommande->setPlat($this);
        }

        return $this;
    }

    public function removeReferenceCommande(CommandeLigne $referenceCommande): self
    {
        if ($this->reference_commande->removeElement($referenceCommande)) {
            // set the owning side to null (unless already changed)
            if ($referenceCommande->getPlat() === $this) {
                $referenceCommande->setPlat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes[] = $commandeLigne;
            $commandeLigne->addQuantityNumber($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            $commandeLigne->removeQuantityNumber($this);
        }

        return $this;
    }

    public function isAEmporter(): ?bool
    {
        return $this->a_emporter;
    }

    public function setAEmporter(bool $a_emporter): self
    {
        $this->a_emporter = $a_emporter;

        return $this;
    }
}
