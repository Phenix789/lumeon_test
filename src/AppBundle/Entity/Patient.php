<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Patient
{
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER  = 3;

    /**
     * @var  int
     */
    private $id;

    /**
     * @var  string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var  \DateTime
     *
     * @Assert\LessThan("today")
     */
    private $dob;

    /**
     * @var  string
     *
     * @Assert\Choice({"m", "f"})
     */
    private $gender;

    /**
     * @var Doctor
     */
    private $doctor;

    /**
     * Patient constructor.
     * @param int $id
     * @param string $name
     * @param \DateTime $dob
     * @param string $gender
     * @param Doctor $doctor
     */
    public function __construct($id = null, $name = null, $dob = null, $gender = null, $doctor = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->doctor = $doctor;
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
     * @return Patient
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
     * @return Patient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param \DateTime $dob
     * @return Patient
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Patient
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Doctor
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @param Doctor $doctor
     * @return Patient
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->doctor ? $this->doctor->getHospital() : null;
    }
}
