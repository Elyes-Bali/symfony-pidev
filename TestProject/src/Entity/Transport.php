<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransportRepository;
use Doctrine\DBAL\Types\Types;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Positive(message:"La capacite doit etre positive.")]
    #[Assert\NotBlank(message:"Entrez la capacite.")]
    #[ORM\Column]
    private ?int $cap = null;

    #[Assert\Choice(choices: ['train', 'voiture', 'avion', 'bateau', 'metro'], message: 'Type invalide. Veuillez choisir parmi train, voiture, avion, bateau ou metro.')]
    #[Assert\NotBlank(message:"Entrez le type.")]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotBlank(message:"Entrez la date de depart.")]
    #[ORM\Column()]
    private ?\DateTime $dd = null;

    #[Assert\NotBlank(message:"Entrez la date d arrivee.")]
    #[ORM\Column()]
    private ?\DateTime $da = null;

    #[Assert\Positive(message:"Le prix doit etre positif.")]
    #[Assert\NotBlank(message:"Entrez le prix.")]
    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: Reservation::class, cascade:["persist","remove"])]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCap(): ?int
    {
        return $this->cap;
    }

    public function setCap(int $cap): static
    {
        $this->cap = $cap;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDd(): ?\DateTime
    {
        return $this->dd;
    }

    public function setDd(\DateTime $dd): static
    {
        $this->dd = $dd;

        return $this;
    }

    public function getDa(): ?\DateTime
    {
        return $this->da;
    }

    public function setDa(\DateTime $da): static
    {
        $this->da = $da;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function __toString():string{
        return $this->id;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setTransports($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getTransports() === $this) {
                $reservation->setTransports(null);
            }
        }

        return $this;
    }


}
