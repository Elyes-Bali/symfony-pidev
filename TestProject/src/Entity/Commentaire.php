<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idComent = null;

    #[ORM\Column(type: 'text')]
    private ?string $contenu = null;

    #[ORM\Column(type: 'string')]
    private ?string $nom = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $datenow = null;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: "post_id", referencedColumnName: "id")]
    private ?Post $post = null;

    public function getIdComent(): ?int
    {
        return $this->idComent;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatenow(): ?string
    {
        // If $datenow is a DateTime object, convert it to a string
        if ($this->datenow instanceof \DateTimeInterface) {
            return $this->datenow->format('Y-m-d H:i:s');
        }

        return $this->datenow;
    }

    public function setDatenow($datenow): static
    {
        if (is_string($datenow)) {
            // Convert string to DateTime
            $datenow = new \DateTime($datenow);
        }

        $this->datenow = $datenow;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }


}
