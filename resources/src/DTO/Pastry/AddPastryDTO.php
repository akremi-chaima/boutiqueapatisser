<?php

namespace App\DTO\Pastry;

class AddPastryDTO
{
    /**
     * @inheritdoc
     */
    private $name;

    /**
     * @inheritdoc
     */
    private $price;

    /**
     * @inheritdoc
     */
    private $description;

    /**
     * @inheritdoc
     */
    private $isVisible;

    /**
     * @inheritdoc
     */
    private $categoryId;

    /**
     * @inheritdoc
     */
    private $subCollectionId;

    /**
     * @inheritdoc
     */
    private $flavourId;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AddPastryDTO
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return AddPastryDTO
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return AddPastryDTO
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param mixed $isVisible
     * @return AddPastryDTO
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     * @return AddPastryDTO
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubCollectionId()
    {
        return $this->subCollectionId;
    }

    /**
     * @param mixed $subCollectionId
     * @return AddPastryDTO
     */
    public function setSubCollectionId($subCollectionId)
    {
        $this->subCollectionId = $subCollectionId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlavourId()
    {
        return $this->flavourId;
    }

    /**
     * @param mixed $flavourId
     * @return AddPastryDTO
     */
    public function setFlavourId($flavourId)
    {
        $this->flavourId = $flavourId;
        return $this;
    }


}