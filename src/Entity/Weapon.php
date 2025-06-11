<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Les dégâts doivent être positifs.")]
    private ?int $damage = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: "Le cooldown ne peut pas être négatif.")]
    private ?float $cooldown = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "Le type est obligatoire.")]
    private ?string $type = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: "Le niveau requis doit être positif ou nul.")]
    private ?int $levelRequired = null;

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

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): static
    {
        $this->damage = $damage;

        return $this;
    }

    public function getCooldown(): ?float
    {
        return $this->cooldown;
    }

    public function setCooldown(float $cooldown): static
    {
        $this->cooldown = $cooldown;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLevelRequired(): ?int
    {
        return $this->levelRequired;
    }

    public function setLevelRequired(int $levelRequired): static
    {
        $this->levelRequired = $levelRequired;

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
