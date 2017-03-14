<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Hospital;
use AppBundle\Fixture;

class HospitalRepository implements RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Hospital|null
     */
    public function selectById($id)
    {
        $hospitals = Fixture::getHospitals();
        foreach ($hospitals as $hospital) {
            if ($hospital->getId() == $id) {
                return $hospital;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function save($entity)
    {
        Fixture::addHospital($entity);
    }
}
