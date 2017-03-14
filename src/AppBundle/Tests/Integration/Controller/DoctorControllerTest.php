<?php

namespace AppBundle\Tests\Integration\Controller;

use AppBundle\Enum\Gender;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DoctorControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private static $client;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        self::$client = self::createClient();
    }

    public function testNewPatientAction()
    {
        self::$client->request(
            Request::METHOD_PUT,
            '/doctors/1/patients',
            [
                'name'   => 'Toto',
                'dob'    => '2010-01-01',
                'gender' => Gender::MALE,
            ]
        );
        $response = self::$client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data);
        $this->assertArrayHasKey('msg', $data);
        $this->assertArrayHasKey('doctor', $data);
        $this->assertArrayHasKey('patients', $data);
        $this->assertCount(3, $data['patients']); //2 in default fixture + new one
    }

    /**
     * @param $name
     * @param $dob
     * @param $gender
     * @param $status
     * @param $errorKey
     *
     * @dataProvider dataNewPatientActionFail
     */
    public function testNewPatientActionFail($name, $dob, $gender, $errorKey)
    {
        self::$client->request(
            Request::METHOD_PUT,
            '/doctors/1/patients',
            [
                'name'   => $name,
                'dob'    => $dob,
                'gender' => $gender,
            ]
        );
        $response = self::$client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data);
        $this->assertArrayHasKey('msg', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey($errorKey, $data['errors']);
    }

    public function dataNewPatientActionFail()
    {
        $name = 'Toto';
        $dob = '2010-01-01';
        $gender = Gender::MALE;

        return [
            [null, $dob, $gender, 'name'],
            ['', $dob, $gender, 'name'],
            [str_repeat('a', 300), $dob, $gender, 'name'],
            [$name, null, $gender, 'dob'],
            [$name, date('Y-m-d', time() + 84600), $gender, 'dob'],
            [$name, $dob, null, 'gender'],
            [$name, $dob, 'a', 'gender'],
        ];
    }
}
