<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $firstname = null;

    #[ORM\Column]
    private ?string $lastname = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 12, unique: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'json')]
    private $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: AdFind::class)]
    private Collection $adFinds;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: AdLost::class)]
    private Collection $adLosts;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: CommentFind::class)]
    private Collection $commentFinds;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: CommentLost::class)]
    private Collection $commentLosts;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: FavoriteFind::class)]
    private Collection $favoriteFinds;

    #[ORM\OneToMany(mappedBy: 'user_fk', targetEntity: FavoriteLost::class)]
    private Collection $favoriteLosts;

    public function __construct()
    {
        $this->adFinds = new ArrayCollection();
        $this->adLosts = new ArrayCollection();
        $this->commentFinds = new ArrayCollection();
        $this->commentLosts = new ArrayCollection();
        $this->favoriteFinds = new ArrayCollection();
        $this->favoriteLosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return Collection<int, AdFind>
     */
    public function getAdFinds(): Collection
    {
        return $this->adFinds;
    }

    public function addAdFind(AdFind $adFind): self
    {
        if (!$this->adFinds->contains($adFind)) {
            $this->adFinds->add($adFind);
            $adFind->setUserFk($this);
        }

        return $this;
    }

    public function removeAdFind(AdFind $adFind): self
    {
        if ($this->adFinds->removeElement($adFind)) {
            // set the owning side to null (unless already changed)
            if ($adFind->getUserFk() === $this) {
                $adFind->setUserFk(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdLost>
     */
    public function getAdLosts(): Collection
    {
        return $this->adLosts;
    }

    public function addAdLost(AdLost $adLost): self
    {
        if (!$this->adLosts->contains($adLost)) {
            $this->adLosts->add($adLost);
            $adLost->setUserFk($this);
        }

        return $this;
    }

    public function removeAdLost(AdLost $adLost): self
    {
        if ($this->adLosts->removeElement($adLost)) {
            // set the owning side to null (unless already changed)
            if ($adLost->getUserFk() === $this) {
                $adLost->setUserFk(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentFind>
     */
    public function getCommentFinds(): Collection
    {
        return $this->commentFinds;
    }

    public function addCommentFind(CommentFind $commentFind): self
    {
        if (!$this->commentFinds->contains($commentFind)) {
            $this->commentFinds->add($commentFind);
            $commentFind->setUserFk($this);
        }

        return $this;
    }

    public function removeCommentFind(CommentFind $commentFind): self
    {
        if ($this->commentFinds->removeElement($commentFind)) {
            // set the owning side to null (unless already changed)
            if ($commentFind->getUserFk() === $this) {
                $commentFind->setUserFk(null);
            }
        }

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
            $commentLost->setUserFk($this);
        }

        return $this;
    }

    public function removeCommentLost(CommentLost $commentLost): self
    {
        if ($this->commentLosts->removeElement($commentLost)) {
            // set the owning side to null (unless already changed)
            if ($commentLost->getUserFk() === $this) {
                $commentLost->setUserFk(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteFind>
     */
    public function getFavoriteFinds(): Collection
    {
        return $this->favoriteFinds;
    }

    public function addFavoriteFind(FavoriteFind $favoriteFind): self
    {
        if (!$this->favoriteFinds->contains($favoriteFind)) {
            $this->favoriteFinds->add($favoriteFind);
            $favoriteFind->setUserFk($this);
        }

        return $this;
    }

    public function removeFavoriteFind(FavoriteFind $favoriteFind): self
    {
        if ($this->favoriteFinds->removeElement($favoriteFind)) {
            // set the owning side to null (unless already changed)
            if ($favoriteFind->getUserFk() === $this) {
                $favoriteFind->setUserFk(null);
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
            $favoriteLost->setUserFk($this);
        }

        return $this;
    }

    public function removeFavoriteLost(FavoriteLost $favoriteLost): self
    {
        if ($this->favoriteLosts->removeElement($favoriteLost)) {
            // set the owning side to null (unless already changed)
            if ($favoriteLost->getUserFk() === $this) {
                $favoriteLost->setUserFk(null);
            }
        }

        return $this;
    }
}
