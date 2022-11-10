<?php

namespace App\Entity;

use App\Repository\RecoveryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecoveryRepository::class)]
class Recovery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $confirm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getConfirm(): ?int
    {
        return $this->confirm;
    }

    public function setConfirm(?int $confirm): self
    {
        $this->confirm = $confirm;

        return $this;
    }
}
