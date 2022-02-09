<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Helpers\CanMakeFactory;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\FriendlyDateTimeString;
use KennethTrecy\Elomocato\CastConfiguration;

class FriendlyDateTimeStringTest extends TestCase {
	use CanMakeFactory;

	private $must_create_basic_test_class = true;
	private $created_at_configuration = [];

	private function createTestClass() {
		if ($this->must_create_basic_test_class) {
			return new class extends File {
				protected $casts = [
					"updated_at" => FriendlyDateTimeString::class
				];
			};
		} else {
			$class = new class
				extends File
				implements CastConfiguration {
				public static $created_at_configuration;

				protected $casts = [
					"created_at" => FriendlyDateTimeString::class
				];

				public function getCastConfiguration() {
					return [
						"created_at" => static::$created_at_configuration
					];
				}
			};
			$class::$created_at_configuration = $this->created_at_configuration;
			return $class;
		}
	}

	public function testGet() {
		$this->must_create_basic_test_class = true;
		$model = $this->makeFactory()->create();
		$now = Carbon::parse($model->getRawOriginal("updated_at"));

		$updated_at = $model->updated_at;

		$this->assertDatabaseHas("files", [
			"updated_at" => $now
		]);
		$this->assertEquals($now->diffForHumans(), $updated_at);
	}

	public function testSet() {
		$this->must_create_basic_test_class = true;
		$model = $this->makeFactory()->create();
		$now = Carbon::parse($model->getRawOriginal("updated_at"));
		$updated_time = $now->addMinutes(3);

		$model->updated_at = $updated_time;
		$model->save();

		$this->assertDatabaseHas("files", [
			"updated_at" => $updated_time
		]);
		$this->assertEquals($updated_time->diffForHumans(), $model->updated_at);
	}

	public function testGetWithPrefix() {
		$this->must_create_basic_test_class = false;
		$this->created_at_configuration = [ "prefix" => "shortAbsolute" ];
		$model = $this->makeFactory()->create();
		$now = Carbon::parse($model->getRawOriginal("updated_at"));

		$created_at = $model->created_at;

		$this->assertDatabaseHas("files", [
			"created_at" => $now
		]);
		$this->assertEquals($now->shortAbsoluteDiffForHumans(), $created_at);
	}

	public function testGetWithPrefixAndArguments() {
		$other = now()->addMonths(1);
		$this->must_create_basic_test_class = false;
		$this->created_at_configuration = [
			"prefix" => "shortRelativeToOther",
			"arguments" => [$other]
		];
		$model = $this->makeFactory()->create();
		$now = Carbon::parse($model->getRawOriginal("updated_at"));

		$created_at = $model->created_at;

		$this->assertDatabaseHas("files", [
			"created_at" => $now
		]);
		$this->assertEquals($now->shortRelativeToOtherDiffForHumans($other), $created_at);
	}

	public function testNullSet() {
		$model = $this->makeFactory()->create();
		$now = Carbon::parse($model->getRawOriginal("updated_at"));

		$model->updated_at = null;
		$model->save();

		$this->assertDatabaseHas("files", [
			"updated_at" => null
		]);
		$this->assertEquals(now()->diffForHumans(), $model->updated_at);
	}
}
