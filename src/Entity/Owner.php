<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
#[ApiResource]
class Owner extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: House::class, orphanRemoval: true)]
    private Collection $houses;

    public function __construct()
    {
        $this->houses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, House>
     */
    public function getHouses(): Collection
    {
        return $this->houses;
    }

    public function addHouse(House $house): static
    {
        if (!$this->houses->contains($house)) {
            $this->houses->add($house);
            $house->setOwner($this);
        }

        return $this;
    }

    public function removeHouse(House $house): static
    {
        if ($this->houses->removeElement($house)) {
            // set the owning side to null (unless already changed)
            if ($house->getOwner() === $this) {
                $house->setOwner(null);
            }
        }

        return $this;
    }
}
