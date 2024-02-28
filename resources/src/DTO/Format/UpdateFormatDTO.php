<?php

namespace App\DTO\Format;

class UpdateFormatDTO extends AddFormatDTO
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
     * @return UpdateFormatDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}