<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;
use AppBundle\Fixture;

class DoctorRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Doctor|null
     */
    public function selectById($id)
    {
        $doctors = Fixture::getDoctors();
        foreach ($doctors as $doctor) {
            if ($doctor->getId() == $id) {
                return $doctor;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function save($entity)
    {
        Fixture::addDoctor($entity);
    }
}
