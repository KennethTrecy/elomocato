<?php

namespace Tests\Helpers;

use Tests\Mocks\Models\FileFactory;

trait CanMakeFactory
{
    protected function makeFactory()
    {
        $class = $this->createTestClass();
        $class_name = get_class($class);
        $factory_class = $class->factory;

        $factory = new $factory_class($class_name);

        return $factory;
    }
}
