<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="idU", columns={"idU"}), @ORM\Index(name="emailU", columns={"emailU"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrec;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=50, nullable=false)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="textRec", type="string", length=500, nullable=false)
     */
    private $textrec;

    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="emailU", type="string", length=255, nullable=false)
     */
    private $emailu;

    public function getIdrec(): ?int
    {
        return $this->idrec;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getTextrec(): ?string
    {
        return $this->textrec;
    }

    public function setTextrec(string $textrec): static
    {
        $this->textrec = $textrec;

        return $this;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): static
    {
        $this->idu = $idu;

        return $this;
    }

    public function getEmailu(): ?string
    {
        return $this->emailu;
    }

    public function setEmailu(string $emailu): static
    {
        $this->emailu = $emailu;

        return $this;
    }


}
