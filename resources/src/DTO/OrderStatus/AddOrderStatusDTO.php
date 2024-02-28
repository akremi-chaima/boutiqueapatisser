<?php

namespace App\DTO\OrderStatus;
class AddOrderStatusDTO
{
    /**
     * @inheritdoc
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AddOrderStatusDTO
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}