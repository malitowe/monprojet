<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Enseignant extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="Created_by")
     */
    private $Created_course;

    /**
     * @ORM\OneToMany(targetEntity=Classe::class, mappedBy="added_by", orphanRemoval=true)
     */
    private $classes_added;

    public function __construct()
    {
        parent::__construct();
        $this->Created_course = new ArrayCollection();
        $this->classes_added = new ArrayCollection();
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCreatedCourse(): Collection
    {
        return $this->Created_course;
    }

    public function addCreatedCourse(Cours $createdCourse): self
    {
        if (!$this->Created_course->contains($createdCourse)) {
            $this->Created_course[] = $createdCourse;
            $createdCourse->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedCourse(Cours $createdCourse): self
    {
        if ($this->Created_course->contains($createdCourse)) {
            $this->Created_course->removeElement($createdCourse);
            // set the owning side to null (unless already changed)
            if ($createdCourse->getCreatedBy() === $this) {
                $createdCourse->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Classe[]
     */
    public function getClassesAdded(): Collection
    {
        return $this->classes_added;
    }

    public function addClassesAdded(Classe $classesAdded): self
    {
        if (!$this->classes_added->contains($classesAdded)) {
            $this->classes_added[] = $classesAdded;
            $classesAdded->setAddedBy($this);
        }

        return $this;
    }

    public function removeClassesAdded(Classe $classesAdded): self
    {
        if ($this->classes_added->contains($classesAdded)) {
            $this->classes_added->removeElement($classesAdded);
            // set the owning side to null (unless already changed)
            if ($classesAdded->getAddedBy() === $this) {
                $classesAdded->setAddedBy(null);
            }
        }

        return $this;
    }
}