<?php

namespace App\Entity;

use App\Repository\CommentFindRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentFindRepository::class)]
class CommentFind
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'commentFinds')]
    private ?AdFind $adFind_fk = null;

    #[ORM\ManyToOne(inversedBy: 'commentFinds')]
    private ?User $user_fk = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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
