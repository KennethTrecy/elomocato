<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Support\Facades\Storage;

/**
 * Automatically creates a temporary URL where to access the file specified in the attribute. When
 * setting an uploaded file, it will be automatically stored and uses the path to the stored file as
 * the value of the attribute in the database.
 *
 * For now, files can be accessed for 10 minutes. In the future, this can be customized.
 */
class TemporaryAccessibleFile extends AccessibleFile
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
        return Storage::temporaryUrl($value, now()->addMinutes(3));
    }
}