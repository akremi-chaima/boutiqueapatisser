<?php

namespace App\DTO\Basket;

class BasketDTO
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
     * @return BasketDTO
     */
    public function setPastries($pastries)
    {
        $this->pastries = $pastries;
        return $this;
    }


}