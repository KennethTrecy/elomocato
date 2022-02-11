<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Automatically creates a URL where to access the file specified in the attribute. When setting an
 * uploaded file, it will be automatically stored and uses the path to the stored file as the value
 * of the attribute in the database.
 */
class AccessibleFile extends NullableCaster
{
    /**
     * Generates a URL where to access the file.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string $value
     * @param array $attributes
     * @return string
     */
    protected function cast($model, $key, $value, $attributes)
    {
        return Storage::url($value);
    }

    /**
     * Stores the file automatically in "/" and returns the path to the stored file.
     *
     * In that way, the raw value in the database is a file path only. You may also pass a string in
     * case the file was already stored.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string|\Illuminate\Http\UploadedFile $value
     * @param array $attributes
     * @return string
     */
    protected function uncast($model, $key, $value, $attributes)
    {
        $path = $value;
        if ($value instanceof UploadedFile) {
            $path = $value->store("/");
        }

        return $path;
    }
}
