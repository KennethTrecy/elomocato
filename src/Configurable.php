<?php

namespace KennethTrecy\Elomocato;

use Illuminate\Database\Eloquent\Model;

/**
 * Contains methods that allow the class to be configurable;
 */
trait Configurable {
    /**
     * Gets the default value in a certain key if there are no custom values for it.
     *
     * Returns `null` if there are no default or custom values.
     *
     * @param \Illuminate\Database\Eloquent\Model|\KennethTrecy\Elomocato\CastConfiguration $model
     * @param string $key
     * @return Configuration
     */
    protected function generateConfiguration($model, $key): Configuration {
        $defaults = $this->generateDefaults();

        $all_custom_configurations = [];
        if ($model instanceof CastConfiguration) {
            $all_custom_configurations = $model->getCastConfiguration();
        }
        $customs = $all_custom_configurations[$key] ?? [];

        return new Configuration($defaults, $customs);
    }

    /**
     * Gnerates default configurations.
     *
     * @return array<string, mixed>
     */
    protected function generateDefaults(): array {
        return [];
    }
}
