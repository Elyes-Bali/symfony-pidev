<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\HebergementRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: HebergementRepository::class)]
class Hebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[Assert\NotBlank(message:"Veuillez saisir la capacite.")]
    #[Assert\Positive(message:"Veuillez saisir une valeur positive.")]
    #[ORM\Column]
    private ?int $capacite = null;

    #[Assert\NotBlank(message:"Veuillez saisir le prix.")]
    #[Assert\Positive(message:"Veuillez saisir une valeur positive.")]
    #[ORM\Column]
    private ?float $prix = null;

    #[Assert\NotBlank(message:"Veuillez saisir l adresse.")]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[Assert\NotBlank(message:"Veuillez saisir le type.")]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotBlank(message:"Veuillez saisir la description.")]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank(message:"Veuillez saisir la categorie.")]
    #[ORM\ManyToOne(inversedBy: 'hebergements')]
    private ?CategorieHeb $categories = null;


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getCategories(): ?CategorieHeb
    {
        return $this->categories;
    }

    public function setCategories(?CategorieHeb $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function __toString():string{
        return $this->id;
    }


}
