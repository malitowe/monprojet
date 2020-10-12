<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

     /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="cours")
     */
    private $classe;


    /**
     * @ORM\OneToMany(targetEntity=Enseignement::class, mappedBy="cours")
     */
    private $enseignements;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="Created_course")
     */
    private $created_by;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Participate_cours")
     */
    private $Participants;


    public function __construct()
    {
        $this->enseignements = new ArrayCollection();
        $this->Participants = new ArrayCollection();
        $this->code = "code";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getCreatedBy(): ?Enseignant
    {
        return $this->created_by;
    }

    public function setCreatedBy(?Enseignant $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants[] = $participant;
            $participant->addParticipateCour($this);
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        if ($this->Participants->contains($participant)) {
            $this->Participants->removeElement($participant);
            $participant->removeParticipateCour($this);
        }

        return $this;
    }



}
