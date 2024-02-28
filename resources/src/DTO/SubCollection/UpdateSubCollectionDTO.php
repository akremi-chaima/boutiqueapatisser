<?php

namespace App\DTO\SubCollection;

class UpdateSubCollectionDTO extends AddSubCollectionDTO
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
     * @return UpdateSubCollectionDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}