<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\HospitalRepository;
use AppBundle\Repository\PatientRepository;

/** @var \Composer\Autoload\ClassLoader $loader */
require __DIR__ . '/../app/autoload.php';
$request = Request::createFromGlobals();

function getHospitalPatients(Request $request)
{
    $hospitalId = $request->get('hospitalId');

    // Let's check to see if we have received the hospital id
    if (!is_numeric($hospitalId)) {
        return new JsonResponse(
            [
                'msg' => 'No hospital information received',
            ],
            400
        );
    }

    $hospitalRepository = new HospitalRepository();
    $patientRepository = new PatientRepository();

    $hospital = $hospitalRepository->selectById($hospitalId);
    if (null === $hospital) {
        return new JsonResponse(['msg' => 'Invalid hospital id'], 404);
    }

    $patients = $patientRepository->selectByHospital($hospital);

    // Return a list of patients along with the original hospital and a message showing success
    return new JsonResponse(
        [
            'patients' => $patients,
            'hospital' => $hospital,
            'msg'      => 'Here are the patients for ' . $hospital->getName(),
        ]
    );
}

$response = getHospitalPatients($request);
$response->send();
