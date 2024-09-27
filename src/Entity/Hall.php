<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: HallRepository::class)]
#[ApiResource]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("api")]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups("api")]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    #[Groups("api")]
    private ?string $projectionQuality = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'hall')]
    private Collection $sessions;

    /**
     * @var Collection<int, Seat>
     */
    #[ORM\OneToMany(targetEntity: Seat::class, mappedBy: 'hall')]
    private Collection $seat;

    #[ORM\ManyToOne(inversedBy: 'hall')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups("api")]
    private ?Cinema $cinema = null;

    /**
     * @var Collection<int, Incident>
     */
    #[ORM\OneToMany(targetEntity: Incident::class, mappedBy: 'hall')]
    private Collection $incidents;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->seat = new ArrayCollection();
        $this->incidents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProjectionQuality(): ?string
    {
        return $this->projectionQuality;
    }

    public function setProjectionQuality(string $projectionQuality): static
    {
        $this->projectionQuality = $projectionQuality;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setHall($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getHall() === $this) {
                $session->setHall(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seat>
     */
    public function getSeat(): Collection
    {
        return $this->seat;
    }

    public function addSeat(Seat $seat): static
    {
        if (!$this->seat->contains($seat)) {
            $this->seat->add($seat);
            $seat->setHall($this);
        }

        return $this;
    }

    public function removeSeat(Seat $seat): static
    {
        if ($this->seat->removeElement($seat)) {
            // set the owning side to null (unless already changed)
            if ($seat->getHall() === $this) {
                $seat->setHall(null);
            }
        }

        return $this;
    }

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): static
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * @return Collection<int, Incident>
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): static
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents->add($incident);
            $incident->setHall($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): static
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getHall() === $this) {
                $incident->setHall(null);
            }
        }

        return $this;
    }
}
