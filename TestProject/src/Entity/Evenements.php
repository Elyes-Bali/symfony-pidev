<?php

namespace App\Entity;
use App\Repository\EvenementsRespository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: EvenementsRespository::class)]
class Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez entrer le nom")]
    private ?string $nom = null ;
// /**
//      * @ORM\Column(type="datetime", nullable=true)
//      * @Assert\DateTime(message="Invalid date format.")
//      */
#[ORM\Column(type: Types::DATE_MUTABLE)]    
private ?\DateTimeInterface $datedebut = null;



    #[Assert\NotBlank(message:"Veuillez entrer la description")]
    #[ORM\Column(length:250)]
    private ?string $description = null;

    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message:"Veuillez entrer le lieu")]
     private ?string $lieu  = null;

     #[ORM\Column(length:255)]

     private ?string $image  = null;

     #[Assert\NotBlank(message:"Veuillez saisir le prix.")]
     #[Assert\Positive(message:"Veuillez saisir une valeur positive.")]
     #[ORM\Column(length:255)]
     
     private ?string $tarif  = null;


     #[Assert\NotBlank(message:"Veuillez saisir le nombre des places disponibles")]
     #[Assert\Positive(message:"Veuillez saisir une valeur positive.")]
     #[ORM\Column]
    private ?int $placesDisponibles = null;

    #[ORM\ManyToOne(targetEntity: Categories::class)]
    #[ORM\JoinColumn(name: "categorie_id", referencedColumnName: "id")]
    private ?Categories $categorie = null;

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

  public function getDatedebut(): ?\DateTimeInterface
  {
      return $this->datedebut;
    }
    
  public function setDatedebut(?\DateTime $datedebut): static
    {
        $this->datedebut = $datedebut;
    
        return $this;
    }
    


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(?string $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getPlacesDisponibles(): ?int
    {
        return $this->placesDisponibles;
    }

    public function setPlacesDisponibles(?int $placesDisponibles): static
    {
        $this->placesDisponibles = $placesDisponibles;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
   
   public function __toString(): string
{
    return (string) $this->id;
}

}
