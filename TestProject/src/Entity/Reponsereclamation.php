<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponsereclamation
 *
 * @ORM\Table(name="reponsereclamation", indexes={@ORM\Index(name="Prenom", columns={"Prenom"}), @ORM\Index(name="idU", columns={"idU"}), @ORM\Index(name="idRec", columns={"idRec"}), @ORM\Index(name="textRec", columns={"intitule"})})
 * @ORM\Entity
 */
class Reponsereclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=20, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=500, nullable=false)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="textRepRec", type="string", length=500, nullable=false)
     */
    private $textreprec;

    /**
     * @var int
     *
     * @ORM\Column(name="idRepRec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreprec;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRec", referencedColumnName="idRec")
     * })
     */
    private $idrec;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): static
    {
        $this->idu = $idu;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTextreprec(): ?string
    {
        return $this->textreprec;
    }

    public function setTextreprec(string $textreprec): static
    {
        $this->textreprec = $textreprec;

        return $this;
    }

    public function getIdreprec(): ?int
    {
        return $this->idreprec;
    }

    public function getIdrec(): ?Reclamation
    {
        return $this->idrec;
    }

    public function setIdrec(?Reclamation $idrec): static
    {
        $this->idrec = $idrec;

        return $this;
    }


}
