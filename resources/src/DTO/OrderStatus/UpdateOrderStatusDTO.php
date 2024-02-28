<?php

namespace App\DTO\OrderStatus;

class UpdateOrderStatusDTO extends AddOrderStatusDTO
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
     * @return UpdateOrderStatusDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}