<?php

namespace App\DTO\BasketContent;
class BasketContentDTO
{
    /**
     * @inheritdoc
     */
    private $quantity;

    /**
     * @inheritdoc
     */
    private $pastryId;

    /**
     * @inheritdoc
     */
    private $formatId;

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return BasketContentDTO
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPastryId()
    {
        return $this->pastryId;
    }

    /**
     * @param mixed $pastryId
     * @return BasketContentDTO
     */
    public function setPastryId($pastryId)
    {
        $this->pastryId = $pastryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormatId()
    {
        return $this->formatId;
    }

    /**
     * @param mixed $formatId
     * @return BasketContentDTO
     */
    public function setFormatId($formatId)
    {
        $this->formatId = $formatId;
        return $this;
    }



}