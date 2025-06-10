<?php

namespace App\Entity;

use App\Repository\LevelEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelEventRepository::class)]
class LevelEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Level::class, inversedBy: 'levelEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;

    #[ORM\Column]
    private ?int $triggerZ = null;

    #[ORM\Column(length: 50)]
    private ?string $eventType = null;

    #[ORM\Column(type: 'text')]
    private ?string $params = null;

    #[ORM\Column(nullable: true)]
    private ?int $sequenceOrder = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function getTriggerZ(): ?int
    {
        return $this->triggerZ;
    }

    public function setTriggerZ(int $triggerZ): static
    {
        $this->triggerZ = $triggerZ;
        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): static
    {
        $this->eventType = $eventType;
        return $this;
    }

    public function getParams(): ?string
    {
        return $this->params;
    }

    public function setParams(string $params): static
    {
        $this->params = $params;
        return $this;
    }

    public function getSequenceOrder(): ?int
    {
        return $this->sequenceOrder;
    }

    public function setSequenceOrder(?int $sequenceOrder): static
    {
        $this->sequenceOrder = $sequenceOrder;
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
