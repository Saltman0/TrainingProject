<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    /**
     * @var Collection<int, BookingSeat>
     */
    #[ORM\OneToMany(targetEntity: BookingSeat::class, mappedBy: 'booking', orphanRemoval: true)]
    private Collection $bookingSeats;

    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Collection<int, BookingSeat>
     */
    public function getBookingSeats(): Collection
    {
        return $this->bookingSeats;
    }

    public function addBookingSeat(BookingSeat $bookingSeat): static
    {
        if (!$this->bookingSeats->contains($bookingSeat)) {
            $this->bookingSeats->add($bookingSeat);
            $bookingSeat->setBooking($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): static
    {
        if ($this->bookingSeats->removeElement($bookingSeat)) {
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getBooking() === $this) {
                $bookingSeat->setBooking(null);
            }
        }

        return $this;
    }
}
