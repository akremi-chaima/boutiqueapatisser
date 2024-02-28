<?php

namespace App\DTO\Pastry;

class UpdatePastryDTO extends AddPastryDTO
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
     * @return UpdatePastryDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}