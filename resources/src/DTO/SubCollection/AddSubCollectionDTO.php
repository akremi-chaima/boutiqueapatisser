<?php

namespace App\DTO\SubCollection;

class AddSubCollectionDTO
{
    /**
     * @inheritdoc
     */
    private $name;

    /**
     * @inheritdoc
     */
    private $isActive;

    /**
     * @inheritdoc
     */
    private $collectionId;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AddSubCollectionDTO
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     * @return AddSubCollectionDTO
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param mixed $collectionId
     * @return AddSubCollectionDTO
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
        return $this;
    }

}