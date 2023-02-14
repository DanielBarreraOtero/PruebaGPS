<?php

namespace App\Entity;

use App\Repository\ParticipanteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use stdClass;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ParticipanteRepository::class)]
#[UniqueEntity(fields: ['indicativo'], message: 'Ya existe una cuenta con este indicativo')]
class Participante implements UserInterface, PasswordAuthenticatedUserInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6, unique: true)]
    private ?string $indicativo = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imagen = null;

    #[ORM\OneToMany(mappedBy: 'participante', targetEntity: Mensaje::class)]
    private Collection $mensajes;

    public function __construct()
    {
        $this->mensajes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndicativo(): ?string
    {
        return $this->indicativo;
    }

    public function setIndicativo(string $indicativo): self
    {
        $this->indicativo = $indicativo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->indicativo;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return Collection<int, Mensaje>
     */
    public function getMensajes(): Collection
    {
        return $this->mensajes;
    }

    public function getMensajesNotLazy(): array
    {
        $misMensajes = [];

        foreach ($this->mensajes as $mensaje) {
            $misMensajes[] = $mensaje;
        }

        return $misMensajes;
    }

    public function addMensaje(Mensaje $mensaje): self
    {
        if (!$this->mensajes->contains($mensaje)) {
            $this->mensajes->add($mensaje);
            $mensaje->setParticipante($this);
        }

        return $this;
    }

    public function removeMensaje(Mensaje $mensaje): self
    {
        if ($this->mensajes->removeElement($mensaje)) {
            // set the owning side to null (unless already changed)
            if ($mensaje->getParticipante() === $this) {
                $mensaje->setParticipante(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $std = new stdClass();

        $std->id = $this->id;
        $std->indicativo = $this->indicativo;
        $std->roles = $this->roles;
        $std->email = $this->email;
        $std->nombre = $this->nombre;
        $std->apellido1 = $this->apellido1;
        $std->apellido1 = $this->apellido2;

        return $std;
    }
}
