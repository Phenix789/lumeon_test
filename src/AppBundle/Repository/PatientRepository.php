<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;
use AppBundle\Fixture;

class PatientRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Patient|null
     */
    public function selectById($id)
    {
        $patients = Fixture::getPatients();
        foreach ($patients as $patient) {
            if ($patient->getId() == $id) {
                return $patient;
            }
        }

        return null;
    }

    /**
     * @param Hospital $hospital
     *
     * @return Patient[]|array
     */
    public function selectByHospital($hospital)
    {
        $result = [];
        $id = $hospital->getId();
        $patients = Fixture::getPatients();
        foreach ($patients as $patient) {
            $h = $patient->getHospital();
            if ($h && $h->getId() == $id) {
                $result[] = $patient;
            }
        }

        return $result;
    }

    /**
     * @param Doctor $doctor
     *
     * @return Patient[]|array
     */
    public function selectByDoctor(Doctor $doctor)
    {
        $result = [];
        $id = $doctor->getId();
        $patients = Fixture::getPatients();
        foreach ($patients as $patient) {
            $d = $patient->getDoctor();
            if ($d && $d->getId() == $id) {
                $result[] = $patient;
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function save($entity)
    {
        Fixture::addPatient($entity);
    }
}
