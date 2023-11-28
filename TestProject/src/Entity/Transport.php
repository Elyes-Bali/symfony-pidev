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


}
