<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use KennethTrecy\Elomocato\Configuration;

class ConfigurationTest extends TestCase
{
    public function testGettingDefault()
    {
        $configuration = new Configuration([
            "hello" => "world"
        ], []);

        $value = $configuration->get("hello");

        $this->assertEquals($value, "world");
    }

    public function testGettingCustom()
    {
        $configuration = new Configuration([], [
            "foo" => "bar"
        ]);

        $value = $configuration->get("foo");

        $this->assertEquals($value, "bar");
    }

    public function testGettingNull()
    {
        $configuration = new Configuration([], []);

        $value = $configuration->get("abcde");

        $this->assertNull($value);
    }

    public function testGettingCustomWithDefault()
    {
        $configuration = new Configuration([
            "foo" => "bar"
        ], [
            "foo" => "baz"
        ]);

        $value = $configuration->get("foo");

        $this->assertEquals($value, "baz");
    }

    public function testSettingNewCustom()
    {
        $configuration = new Configuration([
            "hello" => "universe"
        ], []);

        $configuration->set("hello", "world");
        $value = $configuration->get("hello");

        $this->assertEquals($value, "world");
    }

    public function testSettingExistingCustom()
    {
        $configuration = new Configuration([], [
            "foo" => "baz"
        ]);

        $configuration->set("foo", "bar");
        $value = $configuration->get("foo");

        $this->assertEquals($value, "bar");
    }
}
