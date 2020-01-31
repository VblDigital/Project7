<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table()
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Ce nom de produit est déjà utilisée"
 * )
 *
 * @Hateoas\Relation(
 *    "self",
 *    href = @Hateoas\Route(
 *        "view_products",
 *        absolute = true
 *    ),
 *     exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 *
 *  * @Hateoas\Relation(
 *    "self",
 *    href = @Hateoas\Route(
 *        "view_product",
 *        parameters = {"productId" = "expr(object.getId())"},
 *        absolute = true
 *    ),
 *     exclusion = @Hateoas\Exclusion(groups={"detail"})
 * )
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"detail", "list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail", "list"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail", "list"})
     * @Assert\NotBlank
     */
    private $reference;

    /**
     * @ORM\Column(type="text")
     * @Groups({"detail"})
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     * @Groups({"detail"})
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"detail"})
     * @Assert\NotBlank
     */
    private $stock;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", inversedBy="products")
     * @ORM\JoinTable(name="products_clients")
     */
    private $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function addClient(Client $clients)
    {
        $clients->addProduct($this);
        $this->clients[] = $clients;
    }
}
