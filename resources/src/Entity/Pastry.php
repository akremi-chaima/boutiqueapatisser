<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pastry
 *
 * @ORM\Table(name="pastry")
 * @ORM\Entity
 */
class Pastry
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture", type="string", length=100, nullable=true)
     */
    private $picture;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=false)
     */
    private $isVisible;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Flavour
     *
     * @ORM\ManyToOne(targetEntity="Flavour")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flavour_id", referencedColumnName="id")
     * })
     */
    private $flavour;

    /**
     * @var SubCollection
     *
     * @ORM\ManyToOne(targetEntity="SubCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sub_collection_id", referencedColumnName="id")
     * })
     */
    private $subCollection;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Pastry
     */
    public function setName(string $name): Pastry
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Pastry
     */
    public function setPrice(string $price): Pastry
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Pastry
     */
    public function setDescription(string $description): Pastry
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool $isVisible
     * @return Pastry
     */
    public function setIsVisible(bool $isVisible): Pastry
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Pastry
     */
    public function setCategory(Category $category): Pastry
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Flavour
     */
    public function getFlavour(): Flavour
    {
        return $this->flavour;
    }

    /**
     * @param Flavour $flavour
     * @return Pastry
     */
    public function setFlavour(Flavour $flavour): Pastry
    {
        $this->flavour = $flavour;
        return $this;
    }

    /**
     * @return SubCollection
     */
    public function getSubCollection(): SubCollection
    {
        return $this->subCollection;
    }

    /**
     * @param SubCollection $subCollection
     * @return Pastry
     */
    public function setSubCollection(SubCollection $subCollection): Pastry
    {
        $this->subCollection = $subCollection;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     * @return Pastry
     */
    public function setPicture(?string $picture): Pastry
    {
        $this->picture = $picture;
        return $this;
    }
}
