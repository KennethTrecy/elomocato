<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\FriendlyDateTimeString;
use KennethTrecy\Elomocato\CastConfiguration;

class MockDateFile extends File implements CastConfiguration {
	protected $table = "files";

	public static function createDefault() {
		return static::create([
			"name" => "a.txt",
			"content" => "abc"
		]);
	}

	protected $casts = [
		"created_at" => FriendlyDateTimeString::class,
		"updated_at" => FriendlyDateTimeString::class
	];

	public function getCastConfiguration() {
		return [
			FriendlyDateTimeString::NAMESPACE => [
				"created_at" => [
					"prefix" => "shortAbsolute"
				]
			]
		];
	}
}

class FriendlyDateTimeStringTest extends TestCase {
	public function test_get() {
		$now = now();
		$model = MockDateFile::createDefault();

		$this->assertDatabaseHas("files", [
			"updated_at" => $now
		]);
		$this->assertEquals($now->diffForHumans(), $model->updated_at);
	}

	public function test_set() {
		$now = now();
		$model = MockDateFile::createDefault();
		$updated_time = $now->addMinutes(3);

		$model->updated_at = $updated_time;
		$model->save();

		$this->assertDatabaseHas("files", [
			"updated_at" => $updated_time
		]);
		$this->assertEquals($updated_time->diffForHumans(), $model->updated_at);
	}

	public function test_get_with_prefix() {
		$now = now();
		$model = MockDateFile::createDefault();

		$this->assertDatabaseHas("files", [
			"created_at" => $now
		]);
		$this->assertEquals($now->shortAbsoluteDiffForHumans(), $model->created_at);
	}
}
