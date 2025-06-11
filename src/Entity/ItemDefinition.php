<?php

namespace App\Entity;

use App\Repository\ItemDefinitionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemDefinitionRepository::class)]
class ItemDefinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La clé de l'objet est obligatoire.")]
    private ?string $itemKey = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom de l'objet est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le type d'effet est obligatoire.")]
    private ?string $effectType = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La valeur de l'effet est obligatoire.")]
    #[Assert\Type(type: 'numeric', message: "La valeur de l'effet doit être un nombre.")]
    private $effectValue = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le chemin de l'icône est obligatoire.")]
    private ?string $iconPath = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemKey(): ?string
    {
        return $this->itemKey;
    }

    public function setItemKey(string $itemKey): static
    {
        $this->itemKey = $itemKey;
        return $this;
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

    public function getEffectType(): ?string
    {
        return $this->effectType;
    }

    public function setEffectType(string $effectType): static
    {
        $this->effectType = $effectType;
        return $this;
    }

    public function getEffectValue()
    {
        return $this->effectValue;
    }

    public function setEffectValue($effectValue): static
    {
        $this->effectValue = $effectValue;
        return $this;
    }

    public function getIconPath(): ?string
    {
        return $this->iconPath;
    }

    public function setIconPath(string $iconPath): static
    {
        $this->iconPath = $iconPath;
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
