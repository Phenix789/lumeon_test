<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Hospital;
use AppBundle\Entity\Patient;

class PatientRepository implements RepositoryInterface
{
    /**
     * @return Patient
     */
    public function selectById($id)
    {
        return null;
    }

    /**
     * @param Hospital $hospital
     *
     * @return Patient[]
     */
    public function selectByHospital($hospital)
    {
        return [];
    }

    public function selectByDoctor(Doctor $doctor)
    {
        return [];
    }
}
