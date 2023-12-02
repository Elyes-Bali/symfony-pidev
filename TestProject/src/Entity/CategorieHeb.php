<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CategorieHebRepository;


#[ORM\Entity(repositoryClass: CategorieHebRepository::class)]
class CategorieHeb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int  $id;

    #[Assert\NotBlank(message:"Veuillez saisir le contenu du categorie.")]
    #[ORM\Column(length: 255)]
    private ?string $contenu=null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Hebergement::class, cascade:["persist","remove"])]
    private Collection $hebergements;


    public function __construct()
    {
        $this->hebergements = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function __toString():string{
        return $this->id;
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }

    public function addHebergement(Hebergement $hebergement): static
    {
        if (!$this->hebergements->contains($hebergement)) {
            $this->hebergements->add($hebergement);
            $hebergement->setCategories($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): static
    {
        if ($this->hebergements->removeElement($hebergement)) {
            // set the owning side to null (unless already changed)
            if ($hebergement->getCategories() === $this) {
                $hebergement->setCategories(null);
            }
        }

        return $this;
    }


}
