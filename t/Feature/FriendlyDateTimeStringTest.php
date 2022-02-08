<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\FriendlyDateTimeString;
use KennethTrecy\Elomocato\CastConfiguration;

class MockDateFile extends File {
	protected $table = "files";

	public static function createDefault() {
		return static::create([
			"name" => "a.txt",
			"content" => "abc"
		]);
	}
}

class MockDateFileA extends MockDateFile {
	protected $table = "files";

	protected $casts = [
		"updated_at" => FriendlyDateTimeString::class
	];
}

class MockDateFileB extends MockDateFile implements CastConfiguration {
	protected $table = "files";

	public static $created_at_configuration = [];

	protected $casts = [
		"created_at" => FriendlyDateTimeString::class,
		"updated_at" => FriendlyDateTimeString::class
	];

	public function getCastConfiguration() {
		return [
			FriendlyDateTimeString::NAMESPACE => [
				"created_at" => static::$created_at_configuration
			]
		];
	}
}

class FriendlyDateTimeStringTest extends TestCase {
	public function test_get() {
		$now = now();
		$model = MockDateFileA::createDefault();

		$this->assertDatabaseHas("files", [
			"updated_at" => $now
		]);
		$this->assertEquals($now->diffForHumans(), $model->updated_at);
	}

	public function test_set() {
		$now = now();
		$model = MockDateFileA::createDefault();
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
		$model = MockDateFileB::createDefault();

		MockDateFileB::$created_at_configuration = [
			"prefix" => "shortAbsolute"
		];

		$this->assertDatabaseHas("files", [
			"created_at" => $now
		]);
		$this->assertEquals($now->shortAbsoluteDiffForHumans(), $model->created_at);
	}

	public function test_get_with_prefix_and_arguments() {
		$now = now();
		$other = now()->addMonths(1);
		$model = MockDateFileB::createDefault();

		MockDateFileB::$created_at_configuration = [
			"prefix" => "shortRelativeToOther",
			"arguments" => [$other]
		];

		$this->assertDatabaseHas("files", [
			"created_at" => $now
		]);
		$this->assertEquals($now->shortRelativeToOtherDiffForHumans($other), $model->created_at);
	}
}
