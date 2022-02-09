<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use KennethTrecy\Elomocato\ReverseURLString;

class MockReverseURLFile extends File {
	protected $table = "files";

	protected $casts = [
		"name" => ReverseURLString::class
	];
}

class ReverseURLStringTest extends TestCase {
	public function test_get() {
		$name = "a a.text";
		$encoded_name = urlencode($name);
		$model = MockReverseURLFile::create([
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
		$model = MockReverseURLFile::create([
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

	public function test_null_set() {
		$name = "a a.txt";
		$model = MockReverseURLFile::create([
			"name" => urlencode($name),
			"content" => "abc"
		]);

		$model->name = null;
		$model->save();

		$this->assertDatabaseHas("files", [
			"name" => null
		]);
		$this->assertEquals("", $model->name);
	}
}
