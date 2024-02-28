<?php

namespace App\DTO\Address;

class UpdateAddressDTO extends AddAddressDTO
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
     * @return UpdateAddressDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}