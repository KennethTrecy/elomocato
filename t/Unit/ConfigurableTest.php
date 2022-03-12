<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use KennethTrecy\Elomocato\Configuration;
use KennethTrecy\Elomocato\Configurable;
use KennethTrecy\Elomocato\CastConfiguration;

class ConfigurableTest extends TestCase
{
    public function testGettingConfiguration()
    {
        $model = new class () implements CastConfiguration {
            public function getCastConfiguration()
            {
                return [
                    "hello" => [
                        "foo" => "bar"
                    ]
                ];
            }
        };
        $cast_class = new class () {
            use Configurable;

            public function generateDefaults()
            {
                return [
                    "foo" => "baz"
                ];
            }

            public function getConfiguration($model, $key) {
                return $this->generateConfiguration($model, $key);
            }
        };

        $configuration = $cast_class->getConfiguration($model, "hello");

        $this->assertEquals(
            $configuration,
            new Configuration([ "foo" => "baz" ], [ "foo" => "bar" ])
        );
    }

    public function testGettingNoCustomConfiguration()
    {
        $model = new class () implements CastConfiguration {
            public function getCastConfiguration()
            {
                return [];
            }
        };
        $cast_class = new class () {
            use Configurable;

            public function generateDefaults()
            {
                return [
                    "hello" => "world"
                ];
            }

            public function getConfiguration($model, $key) {
                return $this->generateConfiguration($model, $key);
            }
        };

        $configuration = $cast_class->getConfiguration($model, "foo");

        $this->assertEquals(
            $configuration,
            new Configuration([ "hello" => "world" ], [])
        );
    }

    public function testGettingConfigurationFromRawModel()
    {
        $model = new class () {};
        $cast_class = new class () {
            use Configurable;

            public function generateDefaults()
            {
                return [
                    "hello" => "universe"
                ];
            }

            public function getConfiguration($model, $key) {
                return $this->generateConfiguration($model, $key);
            }
        };

        $configuration = $cast_class->getConfiguration($model, "bar");

        $this->assertEquals(
            $configuration,
            new Configuration([ "hello" => "universe" ], [])
        );
    }

    public function testGettingEmptyConfiguration()
    {
        $model = new class () {};
        $cast_class = new class () {
            use Configurable;

            public function getConfiguration($model, $key) {
                return $this->generateConfiguration($model, $key);
            }
        };

        $configuration = $cast_class->getConfiguration($model, "baz");

        $this->assertEquals(
            $configuration,
            new Configuration([], [])
        );
    }
}
