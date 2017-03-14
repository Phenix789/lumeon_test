#### Question 
Please answer the following question textually.

The file web/showhospitalpatients.php is intended to retrieve a list of patients for a given hospital and return that in json format. Are there any comments you would like to make? What could be improved about the code ?

###### Answer

I have many comments about this file :

 * Use `use` statement for all classes
 
```php
use Symfony\Component\HttpFoundation\JsonResponse;
```
 
 * The error response should specify the status code
 
```php
    return new \Symfony\Component\HttpFoundation\JsonResponse(array(
        'msg' => 'No hospital information received'
    ), 400); //Bad Request
```
 
 * The `$request` should be a parameter, not required from `global`
 * Have a better `$hospitalId` validation (`is_numeric()`)
 * Check if the hospital repository return a non null value (no information from documentation, exception/null ?)
 * PSR-1 & PSR-2 : short array declaration, code style, ...
 * Use the `send()` method instead of `__toString()` from the response object
   * After test, `return getHospitalPatients()` doesn't convert the response object to a string and sent it as response content. So, use `send()` method or at least `echo getHospitalPatients()`
 
You can see changement into the file `web/showhospitalpatients.improved.php`
 
Of course, we could imagine many others changes but it will require deeper refactoring
 * Split responsability from the main function (request validation, repository query, response formating)
 * Better use of Symfony framework, like DI/Container
   * Move repositories as services
   * Create and boot kernel
   * Add the container as parameters
   
```php
$kernel = new AppKernel('prod', false); //or dev
$kernel->boot();

$request = Request::createFromGlobals();
   
function getHospitalPatients(Container $container, Request $request)
{
    //...
    $hospitalRepository = $container->get('repository.hospital');
    //...
}

$response = getHospitalPatients($kernel->getContainer(), $request);
$response->send();
```

 * Move this part to the Symfony controller and override the routing system
 * Use a serialization component (`JMSSerializer`)

#### Test

As a new endpoint, I choose to create a Symfony controller to use the potential of Symfony in the project.
But, to keep the back compatibility, I also add the file `web/newpatient.php` that create a custom request.

###### Database abstraction

To abstract the database, I choose to create a static class `Fixture` where are store the data in plain php.
This abstraction is simple to use but avoid to persist data between request.

###### Entity & Repository

I create a new entity : `Doctor` and like a doctor have an `hospital` attribute, I remove it from `Patient` and add `doctor` attribute.
I keep the function `getHospital()` that return the doctor's hospital.

I also add a method `save()` into `RepositoryInterface` to persist entity. And implement methods according to `Fixture` class.

###### Implementation

Implementation of new endpoint is simple and in classic Symfony way.
I create a controller (`DoctorController`) and a form (`NewPatientType`).
The new endpoint path is on REST way.

###### Serialization

Like I decide to not add new dependencies (like `JMSSerializer`), the serialization is basic and only use the Symfony component `Serializer`.
So, you have duplicate data into the the output.

###### Backcompatibility

Like said above, I create a simple php file to keep the backcompatibility with existing code.
The goal of this file is to create a custom `Request` object to execute the new REST api.
It's an exemple of how we could update an old project.

###### Test manually new endpoint

Start the builtin php http server on port 8000
```bash
app/console server:run -p 8000
```

To call the new endpoint in API way
```
PUT /doctors/{doctor_id}/patients HTTP/1.1
Host: localhost:8000

name=<patient name>&dob=<dob format=yyyy-MM-dd>&gender=<m or f>
```

To call the new endpoint in old way
```
POST /newpatient.php?doctor_id=1 HTTP/1.1
Host: localhost:8000

name=<patient name>&dob=<dob format=yyyy-MM-dd>&gender=<m or f>
```

###### Unit and Integration Test

You can find unit and integration test into the directory `src/AppBundle/Tests` 
Tests are pretty simple and only test controllers.
I decide to not create test for entity and repository because is just a stub.
In the same way, I choose to not test form and validation for this exercice because it covert by integration tests.
