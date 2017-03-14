<?php

namespace AppBundle\Tests\Unit\Controller;

use AppBundle\Controller\AbstractController;
use AppBundle\Tests\TestPrivateMethodTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase
{
    use TestPrivateMethodTrait;

    public function testCreateResponse()
    {
        $payload = ['msg' => 'Test'];
        $content = json_encode($payload);
        $controller = $this->getControllerMock($content);

        $response = $this->call($controller, 'createResponse', [$payload]);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($content, $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateResponseNotFound()
    {
        $controller = $this->getControllerMock();

        $response = $this->call($controller, 'createResponseNotFound');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @param string $content
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|AbstractController
     */
    private function getControllerMock($content = null)
    {
        $controller = $this->getMock(AbstractController::class, ['serialize']);
        $controller->method('serialize')->willReturn($content);

        return $controller;
    }
}
