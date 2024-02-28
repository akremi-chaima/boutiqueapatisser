<?php

namespace App\DTO\Format;
class AddFormatDTO
{
    /**
     * @inheritdoc
     */
    private $name;

    /**
     * @inheritdoc
     */
    private $pastryId;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AddFormatDTO
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPastryId()
    {
        return $this->pastryId;
    }

    /**
     * @param mixed $pastryId
     * @return AddFormatDTO
     */
    public function setPastryId($pastryId)
    {
        $this->pastryId = $pastryId;
        return $this;
    }

}