<?php

namespace App\DTO\Order;
class AddOrderContentDTO
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
     * @return AddOrderContentDTO
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
     * @return AddOrderContentDTO
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
     * @return AddOrderContentDTO
     */
    public function setFormatId($formatId)
    {
        $this->formatId = $formatId;
        return $this;
    }
}