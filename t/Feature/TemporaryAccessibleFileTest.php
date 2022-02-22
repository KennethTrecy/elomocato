<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use Tests\Mocks\Models\Picture;
use Illuminate\Http\UploadedFile;
use Tests\Helpers\CanMakeFactory;
use Illuminate\Support\Facades\Storage;
use KennethTrecy\Elomocato\TemporaryAccessibleFile;

class TemporaryAccessibleFileTest extends TestCase
{
    use CanMakeFactory;

    private function createTestClass()
    {
        return new class () extends Picture {
            protected $casts = [
                "path" => TemporaryAccessibleFile::class
            ];
        };
    }

    public function testGet()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $path = $model->getRawOriginal("path");

        $url = $model->path;

        $this->assertEquals(Storage::temporaryUrl($path, now()->addMinutes(3)), $url);
        Storage::disk("local")->assertExists($path);
    }
}
