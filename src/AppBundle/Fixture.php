<?php

namespace AppBundle;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;
use AppBundle\Enum\Gender;

final class Fixture
{
    /**
     * @var Doctor[]
     */
    private static $doctors;

    /**
     * @var Hospital[]
     */
    private static $hospitals;

    /**
     * @var Patient[]
     */
    private static $patients;

    /**
     * @return Doctor[]
     */
    public static function getDoctors()
    {
        self::init();

        return self::$doctors;
    }

    /**
     * @param Doctor $doctor
     */
    public static function addDoctor($doctor)
    {
        self::init();

        $doctor->setId(count(self::$doctors) + 1);
        self::$doctors[] = $doctor;
    }

    /**
     * @return Hospital[]
     */
    public static function getHospitals()
    {
        self::init();

        return self::$hospitals;
    }

    /**
     * @param Hospital $hospital
     */
    public static function addHospital($hospital)
    {
        self::init();

        $hospital->setId(count(self::$hospitals) + 1);
        self::$hospitals[] = $hospital;
    }

    /**
     * @return Patient[]
     */
    public static function getPatients()
    {
        self::init();

        return self::$patients;
    }

    /**
     * @param Patient $patient
     */
    public static function addPatient($patient)
    {
        self::init();

        $patient->setId(count(self::$patients) + 1);
        self::$patients[] = $patient;
    }

    private static function init()
    {
        if (null === self::$hospitals) {
            //Hospital
            self::$hospitals[] = $h1 = new Hospital(1, 'Sacred Heart Hospital');
            self::$hospitals[] = $h2 = new Hospital(2, 'The Royal London Hospital');

            //Doctors
            self::$doctors[] = $d1 = new Doctor(1, 'Dr. John Michael Dorian', $h1);
            self::$doctors[] = $d2 = new Doctor(2, 'Dr. Elliot Reid', $h1);
            self::$doctors[] = $d3 = new Doctor(3, 'Dr. Bob Kelso', $h2);
            self::$doctors[] = $d4 = new Doctor(4, 'Dr. Perry Cox', $h2);

            //Patients
            self::$patients[] = $p1 = new Patient(1, 'Timothy Wilkie', new \DateTime("1960-01-01"), Gender::MALE, $d1);
            self::$patients[] = $p1 = new Patient(2, 'Garnet Lacie', new \DateTime("1960-01-01"), Gender::FEMALE, $d1);
            self::$patients[] = $p1 = new Patient(3, 'Elton Micah', new \DateTime("1960-01-01"), Gender::MALE, $d2);
            self::$patients[] = $p1 = new Patient(4, 'Jonette Rikki', new \DateTime("1960-01-01"), Gender::FEMALE, $d2);
            self::$patients[] = $p1 = new Patient(5, 'Vinal Colten', new \DateTime("1960-01-01"), Gender::MALE, $d3);
            self::$patients[] = $p1 = new Patient(6, 'Daisy Eva', new \DateTime("1960-01-01"), Gender::FEMALE, $d3);
            self::$patients[] = $p1 = new Patient(7, 'Driskoll Freddy', new \DateTime("1960-01-01"), Gender::MALE, $d4);
            self::$patients[] = $p1 = new Patient(8, 'Kasia Lavonne', new \DateTime("1960-01-01"), Gender::FEMALE, $d4);
        }
    }
}
