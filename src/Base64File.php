<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * It is like `Base64String` but it can also handle binary data from database.
 *
 * The values of attributes associated to the `Base64File` class can either be a stream or a string.
 *
 * Models that uses `Base64File` class must have type attribute indicating the MIME type to use for
 * `data://` stream wrapper.
 *
 * @link https://www.php.net/manual/en/wrappers.data.php
 */
class Base64File extends Base64String implements CastsAttributes {
	/**
	 * Decodes the original value using `base64_decode`.
	 *
	 * If the `$value` is a stream resource, it will output a decoded stream resource  using
	 * `data://` stream wrapper. Note that original stream resource `$value` is not closed
	 * automatically to allow multiple reads.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string|resource $value
	 * @param array $attributes
	 * @return string|resource
	 */
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


	/**
	 * Encodes the value to set using `base64_encode`.
	 *
	 * If the `$value` is a stream resource, it will return an encoded stream resource using
	 * `data://` stream wrapper. Note that stream resource `$value` is not closed automatically.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string|resource $value
	 * @param array $attributes
	 * @return string|resource
	 */
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
