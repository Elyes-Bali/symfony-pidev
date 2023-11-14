<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="transport")
 * @ORM\Entity
 */
class Transport
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
     * @ORM\Column(name="cap", type="integer", nullable=false)
     */
    private $cap;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dd", type="date", nullable=false)
     */
    private $dd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="da", type="date", nullable=false)
     */
    private $da;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    // Getter and Setter methods...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCap(): ?int
    {
        return $this->cap;
    }

    public function setCap(int $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDd(): ?\DateTimeInterface
    {
        return $this->dd;
    }

    public function setDd(\DateTimeInterface $dd): self
    {
        $this->dd = $dd;

        return $this;
    }

    public function getDa(): ?\DateTimeInterface
    {
        return $this->da;
    }

    public function setDa(\DateTimeInterface $da): self
    {
        $this->da = $da;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}

