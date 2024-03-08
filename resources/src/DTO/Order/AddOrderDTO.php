<?php

namespace App\DTO\Order;

class AddOrderDTO
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
     * @return AddOrderDTO
     */
    public function setPastries($pastries)
    {
        $this->pastries = $pastries;
        return $this;
    }
}