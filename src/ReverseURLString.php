<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Automatically encodes the attribute from or decodes the attribute into the database using native
 * `url**` functions.
 */
class ReverseURLString implements CastsAttributes {
	/**
	 * Encodes the original value using `urlencode`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function get($model, $key, $value, $attributes) {
		if (is_null($value)) {
			return $value;
		}
		return urlencode($value);
	}

	/**
	 * Decodes the value to set using `base64_encode`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes) {
		if (is_null($value)) {
			return $value;
		}
		return urldecode($value);
	}
}
