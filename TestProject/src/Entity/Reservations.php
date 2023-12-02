<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationsRespository;
use Symfony\Component\Validator\Constraints as Assert;


  #[ORM\Entity(repositoryClass: ReservationsRespository::class)]
 
class Reservations
{
    
      
      #[ORM\Id]
      #[ORM\GeneratedValue]
      #[ORM\Column]
    private ?int  $id = null;

  
     
     #[ORM\Column]
     #[Assert\NotBlank(message: 'aucune place reservé')]
    private ?int $placesReservees =null;

  
     #[ORM\Column]
     #[Assert\NotBlank(message: 'ajouter id')]
     private ?int $participantId =null;
 

     #[ORM\Column(type: Types::DATETIME_MUTABLE)]
     #[Assert\NotBlank(message: 'ajouter une  date')]
     private ?\DateTime $dateheureReservation;
     
    
      #[ORM\Column]
      #[Assert\NotBlank(message: 'validation ?')]
    private  ?bool $validate = null;

    #[ORM\ManyToOne(targetEntity: Evenements::class)]
#[ORM\JoinColumn(name: "evenement_id", referencedColumnName: "id")]
private ?Evenements $evenement = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlacesReservees(): ?int
    {
        return $this->placesReservees;
    }

    public function setPlacesReservees(?int $placesReservees): static
    {
        $this->placesReservees = $placesReservees;

        return $this;
    }

    public function getParticipantId(): ?int
    {
        return $this->participantId;
    }

    public function setParticipantId(?int $participantId): static
    {
        $this->participantId = $participantId;

        return $this;
    }

    public function getDateheureReservation(): ?\DateTime
    {
        return $this->dateheureReservation;
    }
    
    public function setDateheureReservation(?\DateTime $dateheureReservation): static
    {
        $this->dateheureReservation = $dateheureReservation;
    
        return $this;
    }
    

    public function isValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(?bool $validate): static
    {
        $this->validate = $validate;

        return $this;
    }

    public function getEvenement(): ?Evenements
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenements $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('Reservation #%d', $this->id);
    }
    
}

