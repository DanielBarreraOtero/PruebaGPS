<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use stdClass;

#[ORM\Entity(repositoryClass: MensajeRepository::class)]
class Mensaje implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'mensajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Banda $banda = null;

    #[ORM\ManyToOne(inversedBy: 'mensajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modo $modo = null;

    #[ORM\ManyToOne(inversedBy: 'mensajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participante $participante = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $hora = null;

    #[ORM\Column]
    private ?bool $validado = false;

    #[ORM\Column(length: 6)]
    private ?string $indicativoJuez = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanda(): ?Banda
    {
        return $this->banda;
    }

    public function setBanda(?Banda $banda): self
    {
        $this->banda = $banda;

        return $this;
    }

    public function getModo(): ?Modo
    {
        return $this->modo;
    }

    public function setModo(?Modo $modo): self
    {
        $this->modo = $modo;

        return $this;
    }

    public function getParticipante(): ?Participante
    {
        return $this->participante;
    }

    public function setParticipante(?Participante $participante): self
    {
        $this->participante = $participante;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function isValidado(): ?bool
    {
        return $this->validado;
    }

    public function setValidado(bool $validado): self
    {
        $this->validado = $validado;

        return $this;
    }

    public function getIndicativoJuez(): ?string
    {
        return $this->indicativoJuez;
    }

    public function setIndicativoJuez(string $indicativoJuez): self
    {
        $this->indicativoJuez = $indicativoJuez;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $std = new stdClass();

        $std->id = $this->id;
        $std->banda_id = $this->banda->getId();
        $std->modo_id = $this->modo->getId();
        $std->participante_id = $this->participante->getId();
        $std->hora = $this->hora;
        $std->validado = $this->validado;
        $std->indicativoJuez = $this->indicativoJuez;

        return $std;
    }
}
