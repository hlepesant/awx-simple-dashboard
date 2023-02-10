<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Silo $silo = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: AwxJob::class)]
    private Collection $awxJobs;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->awxJobs = new ArrayCollection();
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

    public function getSilo(): ?Silo
    {
        return $this->silo;
    }

    public function setSilo(?Silo $silo): self
    {
        $this->silo = $silo;

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
            $awxJob->setCustomer($this);
        }

        return $this;
    }

    public function removeAwxJob(AwxJob $awxJob): self
    {
        if ($this->awxJobs->removeElement($awxJob)) {
            // set the owning side to null (unless already changed)
            if ($awxJob->getCustomer() === $this) {
                $awxJob->setCustomer(null);
            }
        }

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
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
}
