<?php

namespace App\Entity;

use App\Repository\EnemyTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EnemyTypeRepository::class)]
class EnemyType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom de l'ennemi est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Les points de vie doivent être positifs.")]
    private ?int $hp = null;

    #[ORM\Column]
    #[Assert\Positive(message: "La vitesse doit être positive.")]
    private ?float $speed = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le pattern est obligatoire.")]
    private ?string $pattern = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: "L'intervalle de tir doit être positif ou nul.")]
    private ?float $fireInterval = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le chemin du modèle est obligatoire.")]
    private ?string $modelPath = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

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

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;
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

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(string $pattern): static
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function getFireInterval(): ?float
    {
        return $this->fireInterval;
    }

    public function setFireInterval(float $fireInterval): static
    {
        $this->fireInterval = $fireInterval;
        return $this;
    }

    public function getModelPath(): ?string
    {
        return $this->modelPath;
    }

    public function setModelPath(string $modelPath): static
    {
        $this->modelPath = $modelPath;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
