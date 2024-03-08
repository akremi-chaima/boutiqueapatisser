<?php

namespace App\DTO\Order;

class OrderDTO
{
    /**
     * @inheritdoc
     */
    private $pastries;

    /**
     * @return mixed
     */
    public function getPastries()
    {
        return $this->pastries;
    }

    /**
     * @param mixed $pastries
     * @return OrderDTO
     */
    public function setPastries($pastries)
    {
        $this->pastries = $pastries;
        return $this;
    }
}