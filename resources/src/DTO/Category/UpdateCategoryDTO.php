<?php

namespace App\DTO\Category;

class UpdateCategoryDTO extends AddCategoryDTO
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
     * @return UpdateCategoryDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}