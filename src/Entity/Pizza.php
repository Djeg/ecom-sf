<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente une simple pizza plutôt délicieuse
 * 
 * @ORM\Entity(repositoryClass=PizzaRepository::class)
 */
class Pizza
{
    /**
     * Représente l'identifiant unique d'une pizza
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Contient le nom de la pizza (ex: Régina, Napolitaine ...)
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
