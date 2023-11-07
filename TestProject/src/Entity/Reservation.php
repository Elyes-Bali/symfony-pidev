<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="transport_id", columns={"transport_id"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="transport_id", type="integer", nullable=false)
     */
    private $transportId;

    /**
     * @var int
     *
     * @ORM\Column(name="client_id", type="integer", nullable=false)
     */
    private $clientId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="debutReservartion", type="date", nullable=true)
     */
    private $debutreservartion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportId(): ?int
    {
        return $this->transportId;
    }

    public function setTransportId(int $transportId): static
    {
        $this->transportId = $transportId;

        return $this;
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

    public function getDebutreservartion(): ?\DateTimeInterface
    {
        return $this->debutreservartion;
    }

    public function setDebutreservartion(?\DateTimeInterface $debutreservartion): static
    {
        $this->debutreservartion = $debutreservartion;

        return $this;
    }


}
