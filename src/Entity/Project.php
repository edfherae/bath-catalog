<?php
namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'project')]
#[ORM\Index(name: 'idx_area', columns: ['area'])]
#[ORM\Index(name: 'idx_floors', columns: ['floors'])]
#[ORM\Index(name: 'idx_has_pool', columns: ['has_pool'])]
class Project {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, columnDefinition: 'TEXT NOT NULL')]
    private ?string $description = null;

    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $area = null;

    #[ORM\Column(columnDefinition: 'TINYINT UNSIGNED NOT NULL')]
    private ?int $floors = null;

    #[ORM\Column(name: 'has_pool', columnDefinition: 'TINYINT(1) NOT NULL DEFAULT 0')]
    private ?bool $hasPool = null;

    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    private ?int $price = null;

    #[ORM\Column(length: 500, name: 'image_url')]
    private ?string $imageUrl = null;

    public function getId() : ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function getArea(): ?int { return $this->area; }
    public function setArea(int $area): static { $this->area = $area; return $this; }

    public function getFloors(): ?int { return $this->floors; }
    public function setFloors(int $floors): static { $this->floors = $floors; return $this; }

    public function isHasPool(): ?bool { return $this->hasPool; }
    public function setHasPool(bool $hasPool): static { $this->hasPool = $hasPool; return $this; }

    public function getPrice(): ?int { return $this->price; }
    public function setPrice(?int $price): static { $this->price = $price; return $this; }

    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(string $imageUrl): static { $this->imageUrl = $imageUrl; return $this; }
}