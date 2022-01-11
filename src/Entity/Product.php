<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext:[
        'groups'=>['product:read']
    ],
    denormalizationContext:[
        'groups'=>['product:write']
    ]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read','product:write'])]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Groups(['product:read','product:write'])]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read','product:write'])]
    private $manufacturer;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:read','product:write'])]
    private $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['product:read'])]
    private $createdAt;

    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read','product:write'])]
    private $storage;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read','product:write'])]
    private $color;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read'])]
    private $slug;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStorage(): ?int
    {
        return $this->storage;
    }

    public function setStorage(int $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
