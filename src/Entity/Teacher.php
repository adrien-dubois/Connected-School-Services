<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user", "teacher", "classroom"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user", "teacher", "classroom"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"teacher"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"teacher"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user", "teacher", "classroom"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user", "teacher", "classroom"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"teacher"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class, inversedBy="teachers")
     * @Groups({"teacher"})
     */
    private $discipline;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, inversedBy="teachers")
     * @Groups({"teacher"})
     */
    private $classroom;

    public function __construct()
    {
        $this->classroom = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->roles = array ('ROLE_TEACHER');
    }

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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
    public function eraseCredentials()
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * @return Collection|Classroom[]
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom[] = $classroom;
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        $this->classroom->removeElement($classroom);

        return $this;
    }
}
