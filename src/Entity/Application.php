<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
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

    #[ORM\OneToMany(mappedBy: 'application', targetEntity: AwxJob::class)]
    private Collection $awxJobs;

    public function __construct()
    {
        $this->awxJobs = new ArrayCollection();
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
     * @return Collection<int, AwxJob>
     */
    public function getAwxJobs(): Collection
    {
        return $this->awxJobs;
    }

    public function addAwxJob(AwxJob $awxJob): self
    {
        if (!$this->awxJobs->contains($awxJob)) {
            $this->awxJobs->add($awxJob);
            $awxJob->setApplication($this);
        }

        return $this;
    }

    public function removeAwxJob(AwxJob $awxJob): self
    {
        if ($this->awxJobs->removeElement($awxJob)) {
            // set the owning side to null (unless already changed)
            if ($awxJob->getApplication() === $this) {
                $awxJob->setApplication(null);
            }
        }

        return $this;
    }
}
