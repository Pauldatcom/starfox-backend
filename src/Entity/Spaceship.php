<?php

namespace App\Entity;

use App\Repository\SpaceshipRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpaceshipRepository::class)]
class Spaceship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom du vaisseau est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column(name: "base_hp")]
    #[Assert\Positive(message: "Les points de vie doivent être positifs.")]
    private ?int $health = null;

    #[ORM\Column(name: "base_speed")]
    #[Assert\Positive(message: "La vitesse doit être positive.")]
    private ?float $speed = null;

    #[ORM\Column(name: "max_bombs")]
    #[Assert\PositiveOrZero(message: "Le nombre de bombes doit être positif ou nul.")]
    private ?int $maxBombs = null;

    #[ORM\Column(name: "created_at", nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: "updated_at", nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): static
    {
        $this->health = $health;
        return $this;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(float $speed): static
    {
        $this->speed = $speed;
        return $this;
    }

    public function getMaxBombs(): ?int
    {
        return $this->maxBombs;
    }

    public function setMaxBombs(int $maxBombs): static
    {
        $this->maxBombs = $maxBombs;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
