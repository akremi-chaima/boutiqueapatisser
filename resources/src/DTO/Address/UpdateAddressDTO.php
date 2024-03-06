<?php

namespace App\DTO\Address;

class UpdateAddressDTO
{

    /**
     * @inheritdoc
     */
    private $id;

    /**
     * @inheritdoc
     */
    private $city;

    /**
     * @inheritdoc
     */
    private $zipCode;

    /**
     * @inheritdoc
     */
    private $street;

    /**
     * @inheritdoc
     */
    private $userId;

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

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return UpdateAddressDTO
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     * @return UpdateAddressDTO
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return UpdateAddressDTO
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return UpdateAddressDTO
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }



}