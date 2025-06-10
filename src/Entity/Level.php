<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: 'text')]
    private ?string $jsonData = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, LevelEvent>
     */
    #[ORM\OneToMany(targetEntity: LevelEvent::class, mappedBy: 'level', orphanRemoval: false)]
    private Collection $levelEvents;

    public function __construct()
    {
        $this->levelEvents = new ArrayCollection();
    }

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

    public function getJsonData(): ?string
    {
        return $this->jsonData;
    }

    public function setJsonData(string $jsonData): static
    {
        $this->jsonData = $jsonData;
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

    /**
     * @return Collection<int, LevelEvent>
     */
    public function getLevelEvents(): Collection
    {
        return $this->levelEvents;
    }

    public function addLevelEvent(LevelEvent $levelEvent): static
    {
        if (!$this->levelEvents->contains($levelEvent)) {
            $this->levelEvents->add($levelEvent);
            $levelEvent->setLevel($this);
        }
        return $this;
    }

    public function removeLevelEvent(LevelEvent $levelEvent): static
    {
        if ($this->levelEvents->removeElement($levelEvent)) {
            if ($levelEvent->getLevel() === $this) {
                $levelEvent->setLevel(null);
            }
        }
        return $this;
    }
}
