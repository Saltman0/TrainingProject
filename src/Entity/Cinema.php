<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CinemaRepository::class)]
#[ApiResource]
class Cinema
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("api")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("api")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups("api")]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Groups("api")]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups("api")]
    private ?\DateTimeInterface $openHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups("api")]
    private ?\DateTimeInterface $closeHour = null;

    /**
     * @var Collection<int, Hall>
     */
    #[ORM\OneToMany(targetEntity: Hall::class, mappedBy: 'cinema')]
    private Collection $hall;

    public function __construct()
    {
        $this->hall = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getOpenHour(): ?\DateTimeInterface
    {
        return $this->openHour;
    }

    public function setOpenHour(\DateTimeInterface $openHour): static
    {
        $this->openHour = $openHour;

        return $this;
    }

    public function getCloseHour(): ?\DateTimeInterface
    {
        return $this->closeHour;
    }

    public function setCloseHour(\DateTimeInterface $closeHour): static
    {
        $this->closeHour = $closeHour;

        return $this;
    }

    /**
     * @return Collection<int, Hall>
     */
    public function getHall(): Collection
    {
        return $this->hall;
    }

    public function addHall(Hall $hall): static
    {
        if (!$this->hall->contains($hall)) {
            $this->hall->add($hall);
            $hall->setCinema($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): static
    {
        if ($this->hall->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getCinema() === $this) {
                $hall->setCinema(null);
            }
        }

        return $this;
    }
}
