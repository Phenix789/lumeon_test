<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use AppBundle\Form\Doctor\NewPatientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends AbstractController
{
    /**
     * @param int $id
     *
     * @return Response
     *
     * @Extra\Route("/doctors/{id}/patients", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getPatientsAction($id)
    {
        $doctor = $this->getDoctorRepository()->selectById($id);
        if (null === $doctor) {
            return $this->createResponseNotFound('Unable to find doctor with id ' . $id);
        }

        $patients = $this->getPatientRepository()->selectByDoctor($doctor);

        return $this->createResponse(
            [
                'doctor'   => $doctor,
                'patients' => $patients,
                'msg'      => 'Patients list for doctor ' . $doctor->getName(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return Response
     *
     * @Extra\Route("/doctors/{id}/patients", methods={"PUT"})
     */
    public function newPatientAction(Request $request, $id)
    {
        $doctor = $this->getDoctorRepository()->selectById($id);
        if (null === $doctor) {
            return $this->createResponseNotFound('Unable to find doctor');
        }

        $patient = new Patient();
        $form = $this->createForm(NewPatientType::class, $patient, ['method' => Request::METHOD_PUT]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setDoctor($doctor);
            $this->getPatientRepository()->save($patient);

            return $this->forward('AppBundle:Doctor:getPatients', ['id' => $doctor->getId()]);
        }

        return $this->createResponseFromFormError($form);
    }
}
