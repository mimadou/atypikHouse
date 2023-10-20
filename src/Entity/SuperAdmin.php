<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SuperAdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuperAdminRepository::class)]
#[ApiResource]
class SuperAdmin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
