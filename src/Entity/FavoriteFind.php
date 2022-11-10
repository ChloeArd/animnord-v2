<?php

namespace App\Entity;

use App\Repository\FavoriteFindRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteFindRepository::class)]
class FavoriteFind
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteFinds')]
    private ?AdFind $adFind_fk = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteFinds')]
    private ?User $user_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdFindFk(): ?AdFind
    {
        return $this->adFind_fk;
    }

    public function setAdFindFk(?AdFind $adFind_fk): self
    {
        $this->adFind_fk = $adFind_fk;

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
