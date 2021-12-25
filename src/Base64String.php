<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Automatically decodes the attrribute from or encodes the attribute into the database using native
 * `base64_*` functions.
 */
class Base64String implements CastsAttributes {
	/**
	 * Decodes the original value using `base64_decode`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function get($model, $key, $value, $attributes) {
		return base64_decode($value);
	}

	/**
	 * Encodes the value to set using `base64_encode`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes) {
		return base64_encode($value);
	}
}
