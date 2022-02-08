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
	const NAMESPACE = "FriendlyDateTimeString";

	protected $namespace;

	function __construct($namespace = null) {
		$this->namespace = $namespace;
		if (!is_null($namespace)) {
			$this->namespace = static::NAMESPACE;
		}
	}

	/**
	 * Encodes the original value to target human-readable format.
	 *
	 * @param \KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function get($model, $key, $value, $attributes) {
		$all_configurations = $model->getCastConfiguration();
		$namespaced_configuration = $all_configurations[$this->namespace] ?? [];
		$key_configuration = $namespaced_configuration[$key] ?? [];
		return Carbon::parse($value)->diffForHumans();
	}

	/**
	 * Sets the original value. It does nothin.
	 *
	 * @param \KennethTrecy\Elomocato\CastConfiguration $model
	 * @param string $key
	 * @param string $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes) {
		return $value;
	}
}
