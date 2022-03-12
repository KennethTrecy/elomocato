<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Support\Facades\Storage;

/**
 * Automatically creates a temporary URL where to access the file specified in the attribute. When
 * setting an uploaded file, it will be automatically stored and uses the path to the stored file as
 * the value of the attribute in the database.
 *
 * For now, files can be accessed for 3 minutes.
 *
 * The class has the following default configuration values:
 * - `disk = null`
 * - `store_path = "/"`
 * - `temporary_time_duration = [3 minutes from the time of requesting the URL]`
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
        $configuration = $this->generateConfiguration($model, $key);
        return Storage::disk($configuration->get("disk"))
            ->temporaryUrl($value, $configuration->get("temporary_time_duration"));
    }

    protected function generateDefaults(): array {
        return array_merge(parent::generateDefaults(), [
            "temporary_time_duration" => now()->addMinutes(3)
        ]);
    }
}
