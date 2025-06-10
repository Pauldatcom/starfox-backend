<?php

namespace App\Entity;

use App\Repository\SpaceshipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpaceshipRepository::class)]
class Spaceship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $baseHp = null;

    #[ORM\Column]
    private ?float $baseSpeed = null;

    #[ORM\Column]
    private ?int $maxBombs = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getBaseHp(): ?int
    {
        return $this->baseHp;
    }

    public function setBaseHp(int $baseHp): static
    {
        $this->baseHp = $baseHp;
        return $this;
    }

    public function getBaseSpeed(): ?float
    {
        return $this->baseSpeed;
    }

    public function setBaseSpeed(float $baseSpeed): static
    {
        $this->baseSpeed = $baseSpeed;
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
