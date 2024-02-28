<?php

namespace App\DTO\Order;
class AddOrderDTO
{
    /**
     * @inheritdoc
     */
    private $userId;

    /**
     * @inheritdoc
     */
    private $orderStatausId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return AddOrderDTO
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderStatausId()
    {
        return $this->orderStatausId;
    }

    /**
     * @param mixed $orderStatausId
     * @return AddOrderDTO
     */
    public function setOrderStatausId($orderStatausId)
    {
        $this->orderStatausId = $orderStatausId;
        return $this;
    }



}