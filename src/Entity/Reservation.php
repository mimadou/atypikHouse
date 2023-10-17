<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reservationCode = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startBooking = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endBooking = null;

    #[ORM\Column]
    private ?int $numberPerson = null;

    #[ORM\Column(length: 255)]
    private ?string $typeAccommodation = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\Column]
    private ?bool $isCancelled = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationCode(): ?string
    {
        return $this->reservationCode;
    }

    public function setReservationCode(string $reservationCode): static
    {
        $this->reservationCode = $reservationCode;

        return $this;
    }

    public function getStartBooking(): ?\DateTimeInterface
    {
        return $this->startBooking;
    }

    public function setStartBooking(\DateTimeInterface $startBooking): static
    {
        $this->startBooking = $startBooking;

        return $this;
    }

    public function getEndBooking(): ?\DateTimeInterface
    {
        return $this->endBooking;
    }

    public function setEndBooking(\DateTimeInterface $endBooking): static
    {
        $this->endBooking = $endBooking;

        return $this;
    }

    public function getNumberPerson(): ?int
    {
        return $this->numberPerson;
    }

    public function setNumberPerson(int $numberPerson): static
    {
        $this->numberPerson = $numberPerson;

        return $this;
    }

    public function getTypeAccommodation(): ?string
    {
        return $this->typeAccommodation;
    }

    public function setTypeAccommodation(string $typeAccommodation): static
    {
        $this->typeAccommodation = $typeAccommodation;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function isIsCancelled(): ?bool
    {
        return $this->isCancelled;
    }

    public function setIsCancelled(bool $isCancelled): static
    {
        $this->isCancelled = $isCancelled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
