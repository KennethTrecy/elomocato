<?php

namespace KennethTrecy\Elomocato;

use Carbon\Carbon;

/**
 * Automatically encodes the datetime difference between the current time and the time value in
 * the applied attribute into human-friendly format.
 *
 * It does nothing when setting value to the database.
 *
 * The class has the following default configuration values:
 * - `prefix = ""`
 * - `arguments = []`
 */
class FriendlyDateTimeString extends NullableCaster
{
    use Configurable;

    /**
     * Encodes the original value to target human-readable format.
     *
     * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     * @return string
     */
    protected function cast($model, $key, $value, $attributes)
    {
        $configuration = $this->generateConfiguration($model, $key);

        $method_name = "diffForHumans";
        if ($configuration->get("prefix") !== "") {
            $method_name = $configuration->get("prefix").ucfirst($method_name);
        }

        $arguments = $configuration->get("arguments");

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
    protected function uncast($model, $key, $value, $attributes)
    {
        return $value;
    }

    protected function generateDefaults(): array {
        return [
            "prefix" => "",
            "arguments" => []
        ];
    }
}
