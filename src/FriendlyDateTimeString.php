<?php

namespace KennethTrecy\Elomocato;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Automatically encodes the datetime difference between the current time and the time value in
 * the applied attribute into human-friendly format.
 *
 * It does nothing when setting value to the database.
 */
class FriendlyDateTimeString implements CastsAttributes {
	/**
	 * Encodes the original value to target human-readable format.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $modelmodel
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function get($model, $key, $value, $attributes) {
		return Carbon::parse($value)->diffForHumans();
	}

	/**
	 * Sets the original value. It does nothin.
	 *
	 * @param \Illuminate\Database\Eloquent\Model $modelmodel
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes) {
		return $value;
	}
}
