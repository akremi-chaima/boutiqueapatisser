<?php

namespace App\DTO\Order;

class OrderFilterDTO
{
    /**
     * @inheritdoc
     */
    private $userName;

    /**
     * @inheritdoc
     */
    private $statusId;

    /**
     * @inheritdoc
     */
    private $date;

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     * @return OrderFilterDTO
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * @param mixed $statusId
     * @return OrderFilterDTO
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return OrderFilterDTO
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}