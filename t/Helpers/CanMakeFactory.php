<?php

namespace Tests\Helpers;

use Tests\Mocks\Models\FileFactory;

trait CanMakeFactory {
	protected function makeFactory() {
		$class = $this->createTestClass();

		$class_name = get_class($class);
		$factory = new class($class_name) extends FileFactory {
			public function __construct($class_name) {
				parent::__construct($class_name);
			}
		};

		return $factory;
	}
}
