<?php

namespace KennethTrecy\Elomocato;

/**
 * Interface that allows the custom cast classes to be configured dynamically.
 */
interface CastConfiguration
{
    /**
     * Returns an associated array which contains the configuration details of custom classes to
     * convert their respective associated attribute.
     *
     * @return array<string, mixed>
     */
    public function getCastConfiguration();
}
