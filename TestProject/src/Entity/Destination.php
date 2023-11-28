<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\DestinationRepository;


#[ORM\Entity(repositoryClass: DestinationRepository::class)]
class Destination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $iddest=null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'countrie is required')]
    private ?string $countries=null;

    public function getIddest(): ?int
    {
        return $this->iddest;
    }

    public function getCountries(): ?string
    {
        return $this->countries;
    }

    public function setCountries(string $countries): static
    {
        $this->countries = $countries;

        return $this;
    }

    public function __toString(): string
    {
        return $this->countries ?? '';
    }


}
