<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Base64File extends Base64String implements CastsAttributes {
	public function get($model, $key, $value, $attributes) {
		if (is_string($value)) {
			return parent::get($model, $key, $value, $attributes);
		} else {
			$copy_buffer = fopen("php://memory", "r+");
			stream_copy_to_stream($value, $copy_buffer);
			fseek($copy_buffer, 0, SEEK_SET);
			$encoded_contents = stream_get_contents($copy_buffer);
			fclose($copy_buffer);

			$type = $model->type;
			return fopen("data://$type;base64,$encoded_contents", "rb");
		}
	}

	public function set($model, $key, $value, $attributes) {
		if (is_string($value)) {
			return parent::set($model, $key, $value, $attributes);
		} else {
			$copy_buffer = fopen("php://memory", "r+");
			stream_copy_to_stream($value, $copy_buffer);
			fseek($copy_buffer, 0, SEEK_SET);
			$decoded_contents = stream_get_contents($copy_buffer);
			$encoded_contents = parent::set($model, $key, $decoded_contents, $attributes);
			fclose($copy_buffer);

			$type = $model->type;
			return fopen("data://$type,$encoded_contents", "rb");
		}
	}
}
