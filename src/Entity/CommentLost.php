<?php

namespace App\Entity;

use App\Repository\CommentLostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentLostRepository::class)]
class CommentLost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'commentLosts')]
    private ?AdLost $adLost_fk = null;

    #[ORM\ManyToOne(inversedBy: 'commentLosts')]
    private ?User $user_fk = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?int $archive = 0; // false

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

    /**
     * @return int|null
     */
    public function getArchive(): ?int
    {
        return $this->archive;
    }

    /**
     * @param int|null $archive
     * @return CommentLost
     */
    public function setArchive(?int $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
