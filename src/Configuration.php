<?php

namespace KennethTrecy\Elomocato;

/**
 * Contains the configuration for some custom cast classes.
 */
class Configuration {
    private array $defaults;
    private array $customs;

    function __construct(array $defaults, array $customs) {
        $this->defaults = $defaults;
        $this->customs = $customs;
    }

    /**
     * Gets the default value in a certain key if there are no custom values for it.
     *
     * Returns `null` if there are no default or custom values.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed {
        $value = $this->defaults[$key] ?? null;
        if (isset($this->customs[$key])) {
            $value = $this->customs[$key];
        }

        return $value;
    }

    /**
     * Defines the value for the certain key.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void {
        $this->customs[$key] = $value;
    }
}
