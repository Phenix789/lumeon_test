<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../app/autoload.php';

//Create custom request
$request = Request::createFromGlobals();
$request->attributes->set('_controller', 'AppBundle:Doctor:newPatient');
$request->attributes->set('_route', 'app_doctor_newpatient');
$request->attributes->set('id', (int)$_GET['doctor_id']);
$request->setMethod(Request::METHOD_PUT);

//Copy/paste from app.php
$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
