<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Helpers\CanMakeFactory;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\ReverseURLString;

class ReverseURLStringTest extends TestCase {
	use CanMakeFactory;

	private function createTestClass() {
		return new class extends File {
			protected $casts = [
				"name" => ReverseURLString::class
			];
		};
	}

	public function testGet() {
		$model = $this->makeFactory()->create();

		$name = $model->name;

		$this->assertDatabaseHas("files", [
			"name" => urldecode($name)
		]);
	}

	public function testSet() {
		$model = $this->makeFactory()->create();
		$updated_model = $this->makeFactory()->make();
		$new_name = $updated_model->name;

		$model->name = $new_name;
		$model->save();

		$this->assertDatabaseHas("files", [
			"name" => urldecode($new_name)
		]);
	}

	public function testNullSet() {
		$name = "a a.txt";
		$model = $this->makeFactory()->create();

		$model->name = null;
		$model->save();

		$this->assertDatabaseHas("files", [
			"name" => null
		]);
		$this->assertEquals("", $model->name);
	}
}
