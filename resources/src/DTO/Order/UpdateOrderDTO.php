<?php

namespace App\DTO\Order;

class UpdateOrderDTO extends AddOrderDTO
{
    /**
     * @inheritdoc
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UpdateOrderDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}