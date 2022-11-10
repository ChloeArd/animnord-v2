<?php

namespace App\Entity;

use App\Repository\FavoriteLostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteLostRepository::class)]
class FavoriteLost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteLosts')]
    private ?AdLost $adLost_fk = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteLosts')]
    private ?User $user_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdLostFk(): ?AdLost
    {
        return $this->adLost_fk;
    }

    public function setAdLostFk(?AdLost $adLost_fk): self
    {
        $this->adLost_fk = $adLost_fk;

        return $this;
    }

    public function getUserFk(): ?User
    {
        return $this->user_fk;
    }

    public function setUserFk(?User $user_fk): self
    {
        $this->user_fk = $user_fk;

        return $this;
    }
}
