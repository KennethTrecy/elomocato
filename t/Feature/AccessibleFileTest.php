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
}
