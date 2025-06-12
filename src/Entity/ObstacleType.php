<?php

namespace App\Entity;

use App\Repository\ObstacleTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ObstacleTypeRepository::class)]
class ObstacleType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom du type d'obstacle est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "La forme est obligatoire.")]
    private ?string $shape = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull(message: "Les dimensions sont obligatoires.")]
    private ?array $dimensions = null;

    #[ORM\Column(name: "created_at")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'boolean')]
#[Assert\NotNull(message: "Le champ collision est obligatoire.")]
private ?bool $collision = null;

#[ORM\Column(type: 'text')]
#[Assert\NotBlank(message: "La description est obligatoire.")]
private ?string $description = null;

#[ORM\Column(length: 20)]
#[Assert\NotBlank(message: "La couleur est obligatoire.")]
private ?string $color = null;

#[ORM\Column(type: 'float')]
#[Assert\Positive(message: "La taille doit être un nombre positif.")]
private ?float $size = null;


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

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): static
    {
        $this->shape = $shape;
        return $this;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): static
    {
        $this->dimensions = $dimensions;
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

    public function isCollision(): ?bool
{
    return $this->collision;
}

public function setCollision(bool $collision): static
{
    $this->collision = $collision;
    return $this;
}

public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(string $description): static
{
    $this->description = $description;
    return $this;
}

public function getColor(): ?string
{
    return $this->color;
}

public function setColor(string $color): static
{
    $this->color = $color;
    return $this;
}

public function getSize(): ?float
{
    return $this->size;
}

public function setSize(float $size): static
{
    $this->size = $size;
    return $this;
}


}
