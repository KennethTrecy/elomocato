<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\Picture;
use Tests\Helpers\CanMakeFactory;
use Illuminate\Support\Facades\Storage;
use KennethTrecy\Elomocato\AccessibleFile;

class AccessibleFileTest extends TestCase
{
    use CanMakeFactory;

    private function createTestClass()
    {
        return new class () extends Picture {
            protected $casts = [
                "path" => AccessibleFile::class
            ];
        };
    }

    public function testGet()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $path = $model->getRawOriginal("path");

        $url = $model->path;

        $this->assertEquals(Storage::url($path), $url);
        Storage::disk("local")->assertExists($path);
    }

    public function testSet()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $updated_model = $this->makeFactory()->make()->toArray();
        $updated_path = ltrim($updated_model["path"], "/storage");

        $model->path = $updated_path;
        $model->save();

        $url = $model->path;
        $this->assertEquals(Storage::url($updated_path), $url);
        Storage::disk("local")->assertExists($updated_path);
    }
}
