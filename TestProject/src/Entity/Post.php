<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id=null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Title cannot be empty.')]
    private ?string $titre = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Subject cannot be empty.')]
    private ?string $sujet = null;

    #[ORM\Column]

    private ?string $image = null;

    #[ORM\Column(name: "date", type: "date", nullable: true)]

    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: "post", targetEntity: Commentaire::class,  orphanRemoval: true )]
    private $commentaires;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }/**
 * @return Collection|Commentaire[]
 */
    public function getCommentaires(): Collection
    {
        return $this->commentaires ;
    }


}
