<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\FriendlyDateTimeString;

class MockDateFile extends File {
	protected $table = "files";

	protected $casts = [
		"updated_at" => FriendlyDateTimeString::class
	];
}

class FriendlyDateTimeStringTest extends TestCase {
	public function test_get() {
		$now = now();
		$model = MockDateFile::create([
			"name" => "a.txt",
			"content" => "abc"
		]);

		$this->assertDatabaseHas("files", [
			"updated_at" => $now
		]);
		$this->assertEquals($now->diffForHumans(), $model->updated_at);
	}

	public function test_set() {
		$now = now();
		$model = MockDateFile::create([
			"name" => "a.txt",
			"content" => "abc"
		]);
		$updated_time = $now->addMinutes(3);

		$model->updated_at = $updated_time;
		$model->save();

		$this->assertDatabaseHas("files", [
			"updated_at" => $updated_time
		]);
		$this->assertEquals($updated_time->diffForHumans(), $model->updated_at);
	}
}
