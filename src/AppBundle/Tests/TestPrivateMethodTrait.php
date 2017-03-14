<?php

namespace AppBundle\Tests;

trait TestPrivateMethodTrait
{
    /**
     * @param object $instance
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    protected function call($instance, $method, $arguments = [])
    {
        $class = new \ReflectionClass($instance);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($instance, $arguments);
    }
}
