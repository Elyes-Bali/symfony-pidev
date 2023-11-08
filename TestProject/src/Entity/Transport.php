<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transport
 *
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
     * @ORM\Column(name="type", type="string", length=33, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="dd", type="string", length=33, nullable=false)
     */
    private $dd;

    /**
     * @var string
     *
     * @ORM\Column(name="da", type="string", length=33, nullable=false)
     */
    private $da;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

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

    public function getDd(): ?string
    {
        return $this->dd;
    }

    public function setDd(string $dd): static
    {
        $this->dd = $dd;

        return $this;
    }

    public function getDa(): ?string
    {
        return $this->da;
    }

    public function setDa(string $da): static
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


}
