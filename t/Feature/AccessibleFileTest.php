<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use Tests\Mocks\Models\Picture;
use Illuminate\Http\UploadedFile;
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

    public function testGetInitialNull()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->make();
        $model->path = null;
        $model->save();
        $model->refresh();

        $url = $model->path;

        $this->assertNull($url);
    }

    public function testSettingString()
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

    public function testSettingNull()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $path = $model->getRawOriginal("path");

        $model->path = null;
        $model->save();

        $url = $model->path;
        $this->assertNull($url);
        Storage::disk("local")->assertMissing($path);
    }

    public function testSettingUploadedFile()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $file = UploadedFile::fake()->image("picture.png");

        $model->path = $file;
        $model->save();
        $model->refresh();

        $path = $model->getRawOriginal("path");
        $url = $model->path;
        $this->assertEquals(Storage::url($path), $url);
        Storage::disk("local")->assertExists($path);
    }

    public function testSetWithPreviousFileDeletedAlready()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();
        $path = $model->getRawOriginal("path");
        Storage::delete($path);

        $model->path = null;
        $model->save();
        $model->refresh();

        $path = $model->getRawOriginal("path");
        $url = $model->path;
        $this->assertNull($url);
        Storage::disk("local")->assertMissing($path);
    }

    public function testSetWithInvalidValue()
    {
        Storage::fake("local");
        $model = $this->makeFactory()->create();

        $this->expectException(Exception::class);

        $model->path = 3.14;
        $model->save();
    }
}
