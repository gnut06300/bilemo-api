<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    paginationItemsPerPage: 3,
    paginationMaximumItemsPerPage: 3,
    paginationClientItemsPerPage: true,
    normalizationContext:[
        'groups'=>['product:read']
    ],
    denormalizationContext:[
        'groups'=>['product:write']
    ],
    collectionOperations:[
        'get',
        'post' => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
    itemOperations:[
        'put' => ["security" => "is_granted('ROLE_ADMIN')"],
        'delete' => ["security" => "is_granted('ROLE_ADMIN')"],
        'get' => [
            'normalization_context' => [
                'groups' => ['product:read', 'product:item:read'],
            ]
        ]
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
    #[Length(min:3)]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Groups(['product:read','product:write'])]
    #[Length(min:3,max:1000)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read','product:write'])]
    #[NotBlank()]
    private $manufacturer;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:read','product:write'])]
    #[NotBlank()]
    private $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['product:item:read'])]
    private $createdAt;

    #[ORM\Column(type: 'integer')]
    #[Groups(['product:item:read','product:write'])]
    private $storage;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:item:read','product:write'])]
    private $color;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:item:read'])]
    private $slug;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $screen;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $das;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $weight;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $lenght;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $widht;

    #[ORM\Column(type: 'float')]
    #[Groups(['product:item:read','product:write'])]
    private $height;

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

    public function getScreen(): ?float
    {
        return $this->screen;
    }

    public function setScreen(float $screen): self
    {
        $this->screen = $screen;

        return $this;
    }

    public function getDas(): ?float
    {
        return $this->das;
    }

    public function setDas(float $das): self
    {
        $this->das = $das;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLenght(): ?float
    {
        return $this->lenght;
    }

    public function setLenght(float $lenght): self
    {
        $this->lenght = $lenght;

        return $this;
    }

    public function getWidht(): ?float
    {
        return $this->widht;
    }

    public function setWidht(float $widht): self
    {
        $this->widht = $widht;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }
}
