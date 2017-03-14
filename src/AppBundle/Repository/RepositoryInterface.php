<?php

namespace AppBundle\Repository;

interface RepositoryInterface
{
    /**
     * Returns an entity of the appropriate type
     *
     * @param int $id
     */
    public function selectById($id);

    /**
     * Save entity
     *
     * @param $entity
     */
    public function save($entity);
}
