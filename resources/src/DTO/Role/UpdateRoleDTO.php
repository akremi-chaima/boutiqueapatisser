<?php

namespace App\DTO\Role;
class UpdateRoleDTO
{

    /**
     * @inheritdoc
     */
    private $id;

    /**
     * @inheritdoc
     */
    private $name;

    /**
     * @inheritdoc
     */
    private $code;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UpdateRoleDTO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return UpdateRoleDTO
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return UpdateRoleDTO
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }




}