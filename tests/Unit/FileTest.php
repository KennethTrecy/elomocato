<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use KennethTrecy\Elomocato\Base64File;

class FileTest extends TestCase {
	public function testString() {
		$caster = new Base64File();
		$sample_string = "hello world";

		$encoded_string = $caster->set(null, null, $sample_string, null);
		$decoded_string = $caster->get(null, null, $encoded_string, null);

		$this->assertEquals($sample_string, $decoded_string);
	}

	public function testStream() {
		$caster = new Base64File();
		$sample_string = "hello world";
		$sample_model = new class { public $type = "text/plain"; };
		$stream = fopen("data://text/plain,$sample_string", "rb");

		$encoded_stream = $caster->set($sample_model, null, $stream, null);
		$decoded_stream = $caster->get($sample_model, null, $encoded_stream, null);

		$this->assertEquals($sample_string, stream_get_contents($decoded_stream));
	}
}
