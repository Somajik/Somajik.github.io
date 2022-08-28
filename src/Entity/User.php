<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\OneToMany(targetEntity=AdminReservation::class, mappedBy="reference_reservation", orphanRemoval=true)
     */
    private $adminReservations;

    /**
     * @ORM\OneToMany(targetEntity=CommandeAEmporter::class, mappedBy="reference_commande", orphanRemoval=true)
     */
    private $commandeAEmporters;

    public function __construct()
    {
        $this->adminReservations = new ArrayCollection();
        $this->commandeAEmporters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return Collection<int, AdminReservation>
     */
    public function getAdminReservations(): Collection
    {
        return $this->adminReservations;
    }

    public function addAdminReservation(AdminReservation $adminReservation): self
    {
        if (!$this->adminReservations->contains($adminReservation)) {
            $this->adminReservations[] = $adminReservation;
            $adminReservation->setReferenceReservation($this);
        }

        return $this;
    }

    public function removeAdminReservation(AdminReservation $adminReservation): self
    {
        if ($this->adminReservations->removeElement($adminReservation)) {
            // set the owning side to null (unless already changed)
            if ($adminReservation->getReferenceReservation() === $this) {
                $adminReservation->setReferenceReservation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeAEmporter>
     */
    public function getCommandeAEmporters(): Collection
    {
        return $this->commandeAEmporters;
    }

    public function addCommandeAEmporter(CommandeAEmporter $commandeAEmporter): self
    {
        if (!$this->commandeAEmporters->contains($commandeAEmporter)) {
            $this->commandeAEmporters[] = $commandeAEmporter;
            $commandeAEmporter->setReferenceCommande($this);
        }

        return $this;
    }

    public function removeCommandeAEmporter(CommandeAEmporter $commandeAEmporter): self
    {
        if ($this->commandeAEmporters->removeElement($commandeAEmporter)) {
            // set the owning side to null (unless already changed)
            if ($commandeAEmporter->getReferenceCommande() === $this) {
                $commandeAEmporter->setReferenceCommande(null);
            }
        }

        return $this;
    }
}
