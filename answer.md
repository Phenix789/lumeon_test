#### Question 
Please answer the following question textually.

The file web/showhospitalpatients.php is intended to retrieve a list of patients for a given hospital and return that in json format. Are there any comments you would like to make? What could be improved about the code ?

#### Answer

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
