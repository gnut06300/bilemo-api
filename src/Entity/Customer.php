<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    normalizationContext:[
        'groups'=>['customer:read']
    ],
    denormalizationContext:[
        'groups'=>['customer:write']
    ],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_USER')"]
    ],
    itemOperations: [
        "get",
        "put" => ["security" => "is_granted('edit', object)"],
        "delete" => ["security" => "is_granted('delete', object)"],
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['client' => 'exact'])]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['customer:read', 'client:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:read', 'customer:write', 'client:read'])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:read', 'customer:write', 'client:read'])]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:read', 'customer:write', 'client:read'])]
    private $lastname;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['customer:read'])]
    private $client;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['customer:read', 'client:read'])]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
}
