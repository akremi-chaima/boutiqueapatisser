<?php

namespace App\DTO\Collection;

class UpdateCollectionDTO extends AddCollectionDTO
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
     * @return UpdateCollectionDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}