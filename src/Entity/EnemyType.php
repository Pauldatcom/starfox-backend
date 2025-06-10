<?php

namespace App\Entity;

use App\Repository\EnemyTypeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnemyTypeRepository::class)]
class EnemyType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hp = null;

    #[ORM\Column]
    private ?float $speed = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pattern = null;

    #[ORM\Column]
    private ?float $fireInterval = null;

    #[ORM\Column(length: 255)]
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
