<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mocks\Models\File;
use Tests\Mocks\Models\FileFactory;
use KennethTrecy\Elomocato\Base64String;

class Base64StringTest extends TestCase {
	public function makeFactory() {
		$class = new class extends File {
			protected $casts = [
				"name" => Base64String::class
			];
		};

		$class_name = get_class($class);
		$factory = new class($class_name) extends FileFactory {
			public function __construct($class_name) {
				parent::__construct($class_name);
			}
		};

		return $factory;
	}

	public function testGet() {
		$model = $this->makeFactory()->create();

		$decoded_name = $model->name;

		$this->assertDatabaseHas("files", [
			"name" => base64_encode($decoded_name)
		]);
	}
}
