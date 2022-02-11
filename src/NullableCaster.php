<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Abstract class that cast the associated attribute only if it is not null.
 */
abstract class NullableCaster implements CastsAttributes {
	/**
	 * Calls `cast()` method if the value is not null. Otherwise, it would return `null`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string|null $value
	 * @param array $attributes
	 * @return mixed|null
	 */
	public function get($model, $key, $value, $attributes) {
		if (is_null($value)) {
			return $value;
		}
		return $this->cast($model, $key, $value, $attributes);
	}

	/**
	 * Calls `uncast()` method if the value is not null. Otherwise, it would return `null`.
	 *
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param mixed $value
	 * @param array $attributes
	 * @return mixed|null
	 */
	public function set($model, $key, $value, $attributes) {
		if (is_null($value)) {
			return $value;
		}
		return $this->uncast($model, $key, $value, $attributes);
	}

	/**
	 * Casts the raw value from database to target type.
	 *
	 * The raw value is guaranteed not to be a null.
	 *
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return mixed
	 */
	protected abstract function cast($model, $key, $value, $attributes);

	/**
	 * Casts the value to target type before it will be set to database.
	 *
	 * The value to cast is guaranteed not to be a null.
	 *
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param mixed $value
	 * @param array $attributes
	 * @return mixed
	 */
	protected abstract function uncast($model, $key, $value, $attributes);
}
