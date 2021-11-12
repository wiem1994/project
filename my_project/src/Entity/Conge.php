<?php

namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CongeRepository::class)
 */
class Conge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $iduser;


    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrejour;

    /**
     * @ORM\Column(type="array")
     */
    private $statut = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getNombrejour(): ?int
    {
        return $this->nombrejour;
    }

    public function setNombrejour(int $nombrejour): self
    {
        $this->nombrejour = $nombrejour;

        return $this;
    }
    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }
    public function getStatut(): ?array
    {
        return $this->statut;
    }

    public function setStatut(array $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
