<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminReservationRepository;

/**
 * @ORM\Entity(repositoryClass=AdminReservationRepository::class)
 */
class AdminReservation
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
    private $guest_number;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $options;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="adminReservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reference_reservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestNumber(): ?int
    {
        return $this->guest_number;
    }

    public function setGuestNumber(int $guest_number): self
    {
        $this->guest_number = $guest_number;

        return $this;
    }


    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus( $status): self
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

    public function getReferenceReservation(): ?User
    {
        return $this->reference_reservation;
    }

    public function setReferenceReservation(?User $reference_reservation): self
    {
        $this->reference_reservation = $reference_reservation;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

}
