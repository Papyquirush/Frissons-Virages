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
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The login roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\ManyToMany(targetEntity: Coaster::class)]
    private Collection $coaster;

    #[ORM\ManyToMany(targetEntity: Park::class)]
    private Collection $park;

    public function __construct()
    {
        $this->coaster = new ArrayCollection();
        $this->park = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this login.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every login at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the login, clear it here
        // $this->plainPassword = null;
    }


    public function getCoaster(): Collection
    {
        return $this->coaster;
    }

    public function getPark(): Collection
    {
        return $this->park;
    }

    public function addCoaster(?Coaster $coaster): static
    {
        if ($coaster && !$this->coaster->contains($coaster)) {
            $this->coaster->add($coaster);
        }

        return $this;
    }

    public function removeCoaster(?object $coaster): void
    {
        if($coaster && $this->coaster->contains($coaster)) {
            $this->coaster->removeElement($coaster);
        }
    }

    public function addPark(?object $park): static
    {
        if ($park && !$this->park->contains($park)) {
            $this->park->add($park);
        }

        return $this;
    }

    public function removePark(?object $park): void
    {
        if($park && $this->park->contains($park)) {
            $this->park->removeElement($park);
        }
    }




}