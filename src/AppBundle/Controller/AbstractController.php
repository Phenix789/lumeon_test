<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractController extends Controller
{
    /**
     * @return \AppBundle\Repository\DoctorRepository
     */
    protected function getDoctorRepository()
    {
        return $this->get('repository.doctor');
    }

    /**
     * @return \AppBundle\Repository\HospitalRepository
     */
    protected function getHospitalRepository()
    {
        return $this->get('repository.hospital');
    }

    /**
     * @return \AppBundle\Repository\PatientRepository
     */
    protected function getPatientRepository()
    {
        return $this->get('repository.patient');
    }

    /**
     * @param mixed $payload
     * @param int $status
     *
     * @return JsonResponse
     */
    protected function createResponse($payload, $status = Response::HTTP_OK)
    {
        $response = new JsonResponse();
        $response->setContent($this->serialize($payload));
        $response->setStatusCode($status);

        return $response;
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function createResponseNotFound($message)
    {
        return $this->createResponse(['msg' => $message], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Form $form
     *
     * @return JsonResponse
     */
    protected function createResponseFromFormError(Form $form)
    {
        $errors = $form->getErrors(true);
        $payload = ['msg' => count($errors) . ' error(s) found'];
        foreach ($errors as $error) {
            $payload['errors'][$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $this->createResponse($payload, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    protected function serialize($data)
    {
        return $this->get('serializer')->serialize($data, 'json');
    }
}
