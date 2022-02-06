<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\ReverseURLString;

class MockFile extends File {
	protected $table = "files";

	protected $casts = [
		"name" => ReverseURLString::class
	];
}

class ReverseURLStringTest extends TestCase {
	public function test_get() {
		$name = "a a.text";
		$encoded_name = urlencode($name);
		$model = MockFile::create([
			"name" => $encoded_name,
			"content" => "abc"
		]);

		$this->assertDatabaseHas("files", [
			"name" => $name
		]);
		$this->assertEquals($encoded_name, $model->name);
	}

	public function test_set() {
		$old_name = "a a.txt";
		$new_name = "b b.txt";
		$model = MockFile::create([
			"name" => urlencode($old_name),
			"content" => "abc"
		]);

		$model->name = $new_name;
		$model->save();

		$this->assertDatabaseHas("files", [
			"name" => $new_name
		]);
		$this->assertEquals(urlencode($new_name), $model->name);
	}
}
