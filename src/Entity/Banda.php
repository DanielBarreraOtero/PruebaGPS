<?php

namespace App\Entity;

use App\Repository\BandaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandaRepository::class)]
class Banda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $distancia = null;

    #[ORM\Column]
    private ?int $rangoMin = null;

    #[ORM\Column]
    private ?int $rangoMax = null;

    #[ORM\OneToMany(mappedBy: 'banda', targetEntity: Mensaje::class)]
    private Collection $mensajes;

    public function __construct()
    {
        $this->mensajes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDistancia(): ?int
    {
        return $this->distancia;
    }

    public function setDistancia(int $distancia): self
    {
        $this->distancia = $distancia;

        return $this;
    }

    public function getRangoMin(): ?int
    {
        return $this->rangoMin;
    }

    public function setRangoMin(int $rangoMin): self
    {
        $this->rangoMin = $rangoMin;

        return $this;
    }

    public function getRangoMax(): ?int
    {
        return $this->rangoMax;
    }

    public function setRangoMax(int $rangoMax): self
    {
        $this->rangoMax = $rangoMax;

        return $this;
    }

    /**
     * @return Collection<int, Mensaje>
     */
    public function getMensajes(): Collection
    {
        return $this->mensajes;
    }

    public function addMensaje(Mensaje $mensaje): self
    {
        if (!$this->mensajes->contains($mensaje)) {
            $this->mensajes->add($mensaje);
            $mensaje->setBanda($this);
        }

        return $this;
    }

    public function removeMensaje(Mensaje $mensaje): self
    {
        if ($this->mensajes->removeElement($mensaje)) {
            // set the owning side to null (unless already changed)
            if ($mensaje->getBanda() === $this) {
                $mensaje->setBanda(null);
            }
        }

        return $this;
    }
}
