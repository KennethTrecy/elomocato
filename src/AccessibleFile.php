<?php

namespace KennethTrecy\Elomocato;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Automatically creates a URL where to access the file specified in the attribute. When setting an
 * uploaded file, it will be automatically stored and uses the path to the stored file as the value
 * of the attribute in the database.
 *
 * The class has the following default values:
 * - `disk = null`
 * - `store_path = "/"`
 */
class AccessibleFile extends NullableCaster
{
    use Configurable;

    /**
     * Deletes the previous file associated if there is an existing one or there is a new file to
     * set.
     *
     * Calls `uncast()` method regardless if there was a file deleted.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string|\Illuminate\Http\UploadedFile|null $value
     * @param array $attributes
     * @return mixed|null
     *
     * @throws Exception
     */
    public function set($model, $key, $value, $attributes)
    {
        $configuration = $this->generateConfiguration($model, $key);
        $previous_path = $model->getRawOriginal($key);

        /**
         * a = There is a previous file.
         * b = Previous file exists in storage.
         * c = There is a new path to set.
         * d = There is a new file to set.
         * e = Explicitly set to null.
         *
         * Delete file only when:
         * 1. a ∧ b ∧ (c ∨ d ∨ e)
         *
         */
        if (is_string($previous_path)) {
            if (Storage::disk($configuration->get("disk"))->exists($previous_path)) {
                $deleteFile = function () use ($configuration, $previous_path) {
                    Storage::disk($configuration->get("disk"))->delete($previous_path);
                };

                if (is_null($value)) {
                    $deleteFile();
                } elseif (is_string($value)) {
                    $deleteFile();
                } elseif ($value instanceof UploadedFile) {
                    $deleteFile();
                } else {
                    throw new Exception("Invalid for accessible file.");
                }
            }
        }

        return $this->uncast($model, $key, $value, $attributes);
    }

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
        return Storage::disk($configuration->get("disk"))->url($value);
    }

    /**
     * Stores the file automatically in "/" and returns the path to the stored file.
     *
     * In that way, the raw value in the database is a file path only. You may also pass a string in
     * case the file was already stored.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param string|\Illuminate\Http\UploadedFile|null $value
     * @param array $attributes
     * @return string
     */
    protected function uncast($model, $key, $value, $attributes)
    {
        $configuration = $this->generateConfiguration($model, $key);
        $path = $value;
        if ($value instanceof UploadedFile) {
            $path = $value->store($configuration->get("store_path"));
        }

        return $path;
    }

    protected function generateDefaults(): array {
        return [
            "disk" => null,
            "store_path" => "/"
        ];
    }
}
