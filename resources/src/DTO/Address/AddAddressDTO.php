<?php

namespace App\DTO\Address;
class AddAddressDTO
{

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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return AddAddressDTO
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
     * @return AddAddressDTO
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
     * @return AddAddressDTO
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
     * @return AddAddressDTO
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }


}