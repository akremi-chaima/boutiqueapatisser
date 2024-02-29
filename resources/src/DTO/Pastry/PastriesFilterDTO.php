<?php

namespace App\DTO\Pastry;

class PastriesFilterDTO
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
     * @inheritdoc
     */
    private $orderBy;


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return PastriesFilterDTO
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
     * @return PastriesFilterDTO
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
     * @return PastriesFilterDTO
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
     * @return PastriesFilterDTO
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
     * @return PastriesFilterDTO
     */
    public function setFlavourId($flavourId)
    {
        $this->flavourId = $flavourId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     * @return PastriesFilterDTO
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }




}