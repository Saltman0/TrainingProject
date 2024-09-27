<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeatRepository::class)]
#[ApiResource]
class Seat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("api")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(pattern: "/(?=.*[A-Z])/" ,message: "Seat row must be a uppercase letter.")]
    #[Assert\NotNull(message: "Seat must have a row.")]
    #[Groups("api")]
    private ?string $row = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Seat number must be greater than 0.")]
    #[Assert\NotNull(message: "Seat must have a number.")]
    #[Groups("api")]
    private ?int $number = null;

    #[ORM\ManyToOne(inversedBy: 'seat')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Seat must have a hall.")]
    #[Groups("api")]
    private ?Hall $hall = null;

    /**
     * @var Collection<int, BookingSeat>
     */
    #[ORM\OneToMany(targetEntity: BookingSeat::class, mappedBy: 'seat')]
    private Collection $bookingSeats;

    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRow(): ?string
    {
        return $this->row;
    }

    public function setRow(string $row): static
    {
        $this->row = $row;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): static
    {
        $this->hall = $hall;

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
            $bookingSeat->setSeat($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): static
    {
        if ($this->bookingSeats->removeElement($bookingSeat)) {
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getSeat() === $this) {
                $bookingSeat->setSeat(null);
            }
        }

        return $this;
    }
}
