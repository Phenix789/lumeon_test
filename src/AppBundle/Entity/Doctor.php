<?php

namespace AppBundle\Entity;

class Doctor
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Hospital
     */
    private $hospital;

    /**
     * Doctor constructor.
     * @param int $id
     * @param string $name
     * @param Hospital $hospital
     */
    public function __construct($id = null, $name = null, $hospital = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hospital = $hospital;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Doctor
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Doctor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital $hospital
     * @return Doctor
     */
    public function setHospital($hospital)
    {
        $this->hospital = $hospital;

        return $this;
    }
}
