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
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function get($model, $key, $value, $attributes) {
		$all_configurations = [];
		if ($model instanceof CastConfiguration) {
			$all_configurations = $model->getCastConfiguration();
		}

		$key_configuration = $all_configurations[$key] ?? [];

		$method_name = "diffForHumans";
		if (isset($key_configuration["prefix"])) {
			$method_name = $key_configuration["prefix"].ucfirst($method_name);
		}

		$arguments = $key_configuration["arguments"] ?? [];

		return Carbon::parse($value)->$method_name(...$arguments);
	}

	/**
	 * Sets the original value. It does nothing.
	 *
	 * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes) {
		return $value;
	}
}
