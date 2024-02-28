<?php

namespace App\DTO\OrderPastries;
class AddOrderPastriesDTO
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
    private $orderId;

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
     * @return AddOrderPastriesDTO
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
     * @return AddOrderPastriesDTO
     */
    public function setPastryId($pastryId)
    {
        $this->pastryId = $pastryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return AddOrderPastriesDTO
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
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
     * @return AddOrderPastriesDTO
     */
    public function setFormatId($formatId)
    {
        $this->formatId = $formatId;
        return $this;
    }


}