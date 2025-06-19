<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "crew")]
class Crew
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $fullname;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: "parent_id", referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    private ?self $parent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname; return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self {
        $this->parent = $parent; return $this;
    }

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $subordinates;

    public function __construct()
    {
        $this->subordinates = new ArrayCollection();
    }

    /**
     * @return Collection|self[]
     */
    public function getSubordinates(): Collection
    {
        return $this->subordinates;
    }

    public function addSubordinate(self $crew): self
    {
        if (!$this->subordinates->contains($crew)) {
            $this->subordinates[] = $crew;
            $crew->setParent($this);
        }

        return $this;
    }

    public function removeSubordinate(self $crew): self
    {
        if ($this->subordinates->removeElement($crew)) {
            if ($crew->getParent() === $this) {
                $crew->setParent(null);
            }
        }

        return $this;
    }
}
