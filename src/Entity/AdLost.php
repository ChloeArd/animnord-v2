<?php

namespace App\Entity;

use App\Repository\AdLostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdLostRepository::class)]
class AdLost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $animal = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $sex = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\Column(length: 255)]
    private ?string $fur = null;

    #[ORM\Column(length: 255)]
    private ?array $color = null;

    #[ORM\Column(length: 255)]
    private ?string $dress = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_lost = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'adLosts')]
    private ?User $user_fk = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'adLost_fk', targetEntity: CommentLost::class)]
    private Collection $commentLosts;

    #[ORM\OneToMany(mappedBy: 'adLost_fk', targetEntity: FavoriteLost::class)]
    private Collection $favoriteLosts;

    public function __construct()
    {
        $this->commentLosts = new ArrayCollection();
        $this->favoriteLosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?string
    {
        return $this->animal;
    }

    public function setAnimal(string $animal): self
    {
        $this->animal = $animal;

        return $this;
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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getFur(): ?string
    {
        return $this->fur;
    }

    public function setFur(string $fur): self
    {
        $this->fur = $fur;

        return $this;
    }

    public function getColor(): ?array
    {
        return $this->color;
    }

    public function setColor(array $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDress(): ?string
    {
        return $this->dress;
    }

    public function setDress(string $dress): self
    {
        $this->dress = $dress;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateLost(): ?\DateTimeInterface
    {
        return $this->date_lost;
    }

    public function setDateLost(\DateTimeInterface $date_lost): self
    {
        $this->date_lost = $date_lost;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, CommentLost>
     */
    public function getCommentLosts(): Collection
    {
        return $this->commentLosts;
    }

    public function addCommentLost(CommentLost $commentLost): self
    {
        if (!$this->commentLosts->contains($commentLost)) {
            $this->commentLosts->add($commentLost);
            $commentLost->setAdLostFk($this);
        }

        return $this;
    }

    public function removeCommentLost(CommentLost $commentLost): self
    {
        if ($this->commentLosts->removeElement($commentLost)) {
            // set the owning side to null (unless already changed)
            if ($commentLost->getAdLostFk() === $this) {
                $commentLost->setAdLostFk(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteLost>
     */
    public function getFavoriteLosts(): Collection
    {
        return $this->favoriteLosts;
    }

    public function addFavoriteLost(FavoriteLost $favoriteLost): self
    {
        if (!$this->favoriteLosts->contains($favoriteLost)) {
            $this->favoriteLosts->add($favoriteLost);
            $favoriteLost->setAdLostFk($this);
        }

        return $this;
    }

    public function removeFavoriteLost(FavoriteLost $favoriteLost): self
    {
        if ($this->favoriteLosts->removeElement($favoriteLost)) {
            // set the owning side to null (unless already changed)
            if ($favoriteLost->getAdLostFk() === $this) {
                $favoriteLost->setAdLostFk(null);
            }
        }

        return $this;
    }
}
