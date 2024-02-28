<?php

namespace App\DTO\Flavour;

class UpdateFlavourDTO extends AddFlavourDTO
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
     * @return UpdateFlavourDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}