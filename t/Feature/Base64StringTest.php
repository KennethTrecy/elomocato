<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use Tests\Helpers\CanMakeFactory;
use KennethTrecy\Elomocato\Base64String;

class Base64StringTest extends TestCase
{
    use CanMakeFactory;

    private function createTestClass()
    {
        return new class () extends File {
            protected $casts = [
                "name" => Base64String::class
            ];
        };
    }

    public function testGet()
    {
        $model = $this->makeFactory()->create();

        $decoded_name = $model->name;

        $this->assertDatabaseHas("files", [
            "name" => base64_encode($decoded_name)
        ]);
    }

    public function testSet()
    {
        $model = $this->makeFactory()->create();
        $updated_model = $this->makeFactory()->make();

        $model->name = $updated_model->name;
        $model->save();

        $this->assertDatabaseHas("files", [
            "name" => base64_encode($updated_model->name)
        ]);
    }

    public function testNullSet()
    {
        $model = $this->makeFactory()->create();

        $model->name = null;
        $model->save();

        $this->assertDatabaseHas("files", [
            "name" => null
        ]);
    }
}
