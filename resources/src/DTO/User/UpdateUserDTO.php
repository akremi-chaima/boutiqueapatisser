<?php

namespace App\DTO\User;

class UpdateUserDTO extends AddUserDTO
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
     * @return UpdateUserDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}