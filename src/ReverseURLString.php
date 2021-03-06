<?php

namespace KennethTrecy\Elomocato;

/**
 * Automatically encodes the attribute from or decodes the attribute into the database using native
 * `url_*` functions.
 */
class ReverseURLString extends NullableCaster
{
    /**
     * Encodes the original value using `urlencode`.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     * @return string
     */
    protected function cast($model, $key, $value, $attributes)
    {
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
    protected function uncast($model, $key, $value, $attributes)
    {
        return urldecode($value);
    }
}
