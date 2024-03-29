<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}})
 * @UniqueEntity(fields={"email"}, message="Cet email a déjà été utilisé sur ce site.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le champ Email est obligatoire")
     * @Assert\Email(message = "L'adresse '{{ value }}' n'est pas une adresse mail valide.")
     * @Assert\Length(max="100", maxMessage="L'adresse mail ne doit pas dépasser {{ limit }} caractères")
     * @Groups({"user:read", "user:write"})
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("user:read")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("user:write")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le champ Prénom est obligatoire")
     * @Assert\Length(max=255, maxMessage="Le prénom ne doit pas dépasser {{ limit }} caractères")
     * @Groups({"user:read", "user:write"})
     */
    private string $firstname;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le champ Prénom est obligatoire")
     * @Assert\Length(max=255, maxMessage="Le prénom ne doit pas dépasser {{ limit }} caractères")
     * @Groups({"user:read", "user:write"})
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $phone;

    /**
     * @ORM\OneToOne(targetEntity=Company::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private ?Company $company = null;

    /**
     * @ORM\OneToOne(targetEntity=Student::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private ?Student $student = null;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getUsername(): string
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
     * @see UserInterface
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
