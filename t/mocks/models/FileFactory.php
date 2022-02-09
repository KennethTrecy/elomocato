<?php

namespace Tests\Mocks\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class File extends Factory {
	function __construct($model = null) {
		$this->model = $model;
		parent::__construct();
	}

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			"name" => $this->faker->word(),
			"content" => $this->faker->paragraph()
		];
	}

	public function customValues(array $custom_values) {
		return $this->state([ "name" => $custom_values ]);
	}
}
