<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'inventory', targetEntity: Silo::class, orphanRemoval: true)]
    private Collection $silos;

    public function __construct()
    {
        $this->silos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Silo>
     */
    public function getSilos(): Collection
    {
        return $this->silos;
    }

    public function addSilo(Silo $silo): self
    {
        if (!$this->silos->contains($silo)) {
            $this->silos->add($silo);
            $silo->setInventory($this);
        }

        return $this;
    }

    public function removeSilo(Silo $silo): self
    {
        if ($this->silos->removeElement($silo)) {
            // set the owning side to null (unless already changed)
            if ($silo->getInventory() === $this) {
                $silo->setInventory(null);
            }
        }

        return $this;
    }
}
