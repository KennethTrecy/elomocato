<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase {
	use RefreshDatabase;

	public function setUp(): void {
		parent::setUp();

		$this->loadMigrationsFrom(__DIR__.'/mocks/migrations');
	}
}
