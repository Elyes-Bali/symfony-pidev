<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Positive(message:"L ID du Client doit etre positif.")]
    #[Assert\NotBlank(message:"Entrez le client.")]
    #[ORM\Column]
    private ?int $clientId = null;

    #[Assert\NotBlank(message:"Entrez la date de reservation.")]
    #[ORM\Column()]
    private ?\DateTime $debutreservartion;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Transport $transport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getDebutreservartion(): ?\DateTime
    {
        return $this->debutreservartion;
    }

    public function setDebutreservartion(\DateTime $debutreservartion): static
    {
        $this->debutreservartion = $debutreservartion;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): static
    {
        $this->transport = $transport;

        return $this;
    }


}
