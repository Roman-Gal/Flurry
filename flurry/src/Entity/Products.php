<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_create = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_modified = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $product_image = null;

    /*TODO: remake to OneToMany entity*/
    #[ORM\Column(length: 60, nullable: true)]
    private ?string $product_type = null;

    #[ORM\Column(type: "text", nullable: true, length: 3000)]
    private ?string $product_description = null;

    #[ORM\Column(nullable: true)]
    private ?float $likes = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    /*TODO: remake to OneToMany entity*/
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tags = null;
     
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeImmutable
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeImmutable $date_create): static 
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->date_modified;
    }

    public function setDateModified(\DateTimeInterface $date_modified): static
    {
        $this->date_modified = $date_modified;

        return $this;
    }

    public function getProductImage(): ?string
    {
        return $this->product_image;
    }

    public function setProductImage(?string $product_image): static
    {
        $this->product_image = $product_image;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->product_type;
    }

    public function setProductType(?string $product_type): static
    {
        $this->product_type = $product_type;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }

    public function setProductDescription(?string $product_description): static
    {
        $this->product_description = $product_description;

        return $this;
    }

    public function getLikes(): ?float
    {
        return $this->likes;
    }

    public function setLikes(?float $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    
}
